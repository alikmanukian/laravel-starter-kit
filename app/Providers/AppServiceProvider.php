<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Kernel;
use App\Logging\TelegramLogger;
use Carbon\CarbonInterval as Interval;
use Closure;
use DateInterval;
use DateTimeInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Events\PreparingResponse;
use Illuminate\Routing\Events\ResponsePrepared;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Logtail\Monolog\LogtailHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TelegramLogger::class, function () {
            return new TelegramLogger(
                apiKey: config('logging.channels.telegram.token'),
                channel: config('logging.channels.telegram.chat_id'),
                level: config('logging.channels.telegram.level'),
            );
        });

        $this->app->bind(LogtailHandler::class, function () {
            return new LogtailHandler(
                sourceToken: config('logging.channels.logtail.source_token'),
                level: config('logging.channels.logtail.level'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping(); // remove data wrapper from api responses

        $this->loggingOnLazyLoading(); // log on lazy loading violations

        $this->loggingOnSlowDBQueries(); // log on slow database queries

        $this->loggingOnSlowRequests(); // log on slow requests

        $this->defineCacheMacros(); // define custom cache macros
    }

    protected function loggingOnLazyLoading(): void
    {
        // prevent lazy loading in local and testing environments
        // Model::preventLazyLoading(! app()->isProduction());
        Model::preventLazyLoading();

        if (app()->isProduction()) {
            // handle lazy loading violations on the production environment
            Model::handleLazyLoadingViolationUsing(
                static fn ($model, $relation) => Log::warning("Lazy loading violation: {$model} -> {$relation}")
            );
        }

        // catching lazy loading violations from views and resources
        $preparingResponse = false;

        Event::listen([
            PreparingResponse::class,
            // this event is fired before the response is prepared (it happens when we are running php code from views or resources)
            ResponsePrepared::class,
            // this event is fired after the response is prepared (it happens when we are running php code from views or resources)
        ], static function ($event) use (&$preparingResponse) {
            $preparingResponse = $event instanceof PreparingResponse;
        });

        DB::listen(static function ($query) use (&$preparingResponse) {
            if ($preparingResponse) {
                Log::warning("Lazy loading violation: {$query->sql}");
            }
        });
    }

    /**
     * @throws BindingResolutionException
     */
    protected function loggingOnSlowRequests(): void
    {
        $this->app->make(Kernel::class)->whenRequestLifecycleIsLongerThan(
            Interval::seconds($sec = config('app.log.long_running_requests_interval_in_seconds')),
            static fn () => Log::warning("Request exceeded {$sec} seconds")
        );
    }

    protected function loggingOnSlowDBQueries(): void
    {
        // This method will run a specific action if a database query takes more than 5 seconds during a request or job
        DB::whenQueryingForLongerThan(
            Interval::seconds($sec = config('app.log.long_running_queries_interval_per_connection_in_seconds')),
            // It's important to note that this method works on a per-connection basis, which means you'll receive detailed information about the specific connection that experienced the slowdown.
            static fn ($connection, $event) => Log::warning(
                "Database queries exceeded {$sec} seconds on {$connection->getName()}"
            )
        );

        // catch one long query
        // If you want to run a callback when a single query takes a long time, you can do that with a DB::listen callback.
        DB::listen(static function ($query) {
            $seconds = $query->time / 1000; // convert to seconds

            if ($seconds > config('app.log.slow_query_interval_in_seconds')) {
                Log::debug("Slow query: {$query->sql} with {$seconds} ms");
            }
        });
    }

    protected function defineCacheMacros(): void
    {
        /**
         * This method will define a custom cache macro that will implement the stale-while-revalidate strategy
         *
         * @see https://web.dev/stale-while-revalidate/
         *
         * @usage:
         * Cache::staleWhileRevalidate(
         *  key: 'users',
         *  ttl: [
         *      now()->addHour(), // fresh
         *      now()->addWeek(), // stale
         *  ],
         *  callback: fn() => User::all()
         * );
         */
        Cache::macro(
            name: 'staleWhileRevalidate',
            /**
             * @param  array<int, DateInterval|DateTimeInterface|int>  $ttl  ,
             */
            macro: function (string $key, array $ttl, Closure $callback) {
                [$ttl1, $ttl2] = $ttl;

                if (Cache::has($key)) {
                    return Cache::get($key);
                }

                $getValueAndPutInCache = function ($key, $callback, $ttl1, $ttl2) {
                    if (Cache::has($key.':fetching')) {
                        return null;
                    }

                    Cache::put($key.':fetching', true, $ttl1);
                    $value = $callback();
                    Cache::forget($key.':fetching');

                    Cache::put($key, $value, $ttl1);
                    Cache::put($key.':stale', $value, $ttl2);

                    return $value;
                };

                if (Cache::has($key.':stale')) {
                    dispatch(function () use ($key, $callback, $ttl1, $ttl2, $getValueAndPutInCache) {
                        /** @important: this will not work from Jobs or tinkerwell, because App is not terminating there */
                        $getValueAndPutInCache($key, $callback, $ttl1, $ttl2);
                    })->afterResponse();

                    return Cache::get($key.':stale');
                }

                // first run put in cache
                return $getValueAndPutInCache($key, $callback, $ttl1, $ttl2);
            }
        );
    }
}
