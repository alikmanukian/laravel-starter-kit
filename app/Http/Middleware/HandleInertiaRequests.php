<?php

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
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
        return array_merge(parent::share($request), [
            'config' => config()->get([
                'app.name',
                'app.locale',
                'services.recaptcha.enabled',
                'services.recaptcha.key',
                'services.recaptcha.score',
            ]),
            'auth' => [
                'user' => $request->user() ? UserResource::make($request->user()) : null,
                'features' => collect(config('fortify.features'))
                    ->mapWithKeys(fn ($key) => [$key => true]),
            ],
            'toast' => session('toast'),
        ]);
    }
}
