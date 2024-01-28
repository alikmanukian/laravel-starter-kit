<?php

declare(strict_types=1);

namespace App\Providers;

use App\Logging\TelegramLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
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
        // remove data wrapper from api responses
        JsonResource::withoutWrapping();

        // prevent lazy loading in local and testing environments
        Model::preventLazyLoading(! app()->isProduction());
    }
}
