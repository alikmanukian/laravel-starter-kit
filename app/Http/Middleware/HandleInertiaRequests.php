<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     */
    public function share(Request $request): array
    {
        $error = Cache::get('flash.error');
        Cache::forget('flash.error'); // in case we put not as flash message while redirects

        return array_merge(parent::share($request), [
            'config' => config()->get([
                'app.name',
                'app.locale',
                'app.env',
            ]),
            'auth' => [
                'user' => $request->user() ? UserResource::make($request->user()) : null,
                'features' => collect(config('fortify.features'))
                    ->mapWithKeys(fn (string $key) => [$key => true]),
            ],
            'flash' => [
                'toast' => session('toast'),
                'error' => $error,
            ],
            'ziggy' => [
                'route_name' => Route::currentRouteName(),
            ],
        ]);
    }
}
