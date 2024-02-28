<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia;

class TestingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (! app()->runningUnitTests()) {
            return;
        }

        $this->defineInertiaAsserts();
    }

    protected function defineInertiaAsserts(): void
    {
        AssertableInertia::macro('equal', function (string $key, mixed $value) {
            /** @var AssertableInertia $this */
            $this->has($key);

            if ($value instanceof JsonResource) {
                // @phpstan-ignore-next-line
                expect($this->prop($key))->toEqual($value->resolve());
            } else {
                // @phpstan-ignore-next-line
                expect($this->prop($key))->toEqual($value);
            }

            return $this;
        });

        AssertableInertia::macro('hasResource', function (string $key, JsonResource $resource) {
            /** @var AssertableInertia $this */
            $this->has($key);
            // @phpstan-ignore-next-line
            expect($this->prop($key))->toEqual($resource->resolve());

            return $this;
        });

        AssertableInertia::macro('hasResourceCollection', function (string $key, ResourceCollection $resource) {
            /** @var AssertableInertia $this */
            // @phpstan-ignore-next-line
            return $this->hasResource($key, $resource);
        });

        AssertableInertia::macro('hasPaginatedResource', function (string $key, ResourceCollection $resource) {
            /** @var AssertableInertia $this */
            // @phpstan-ignore-next-line
            expect($this->prop($key))->toHaveKeys(['data', 'links', 'meta']);

            // @phpstan-ignore-next-line
            return $this->hasResource("{$key}.data", $resource);
        });

        TestResponse::macro('assertInertiaComponent', function (string $component, array $params = []) {
            /** @var TestResponse $this */
            return $this->assertInertia(function (AssertableInertia $inertia) use ($component, $params) {
                $itertia = $inertia->component($component, true);

                $isAssociative = count(array_filter(array_keys($params), 'is_string')) > 0;

                if (! $isAssociative) {
                    return $itertia->hasAll($params);
                }

                foreach ($params as $key => $value) {
                    // @phpstan-ignore-next-line
                    $itertia->equal($key, $value);
                }

                return $itertia;
            });
        });

        TestResponse::macro('assertHasInertiaResource', function (string $key, JsonResource $resource) {
            /** @var TestResponse $this */
            return $this->assertInertia(
                // @phpstan-ignore-next-line
                fn (AssertableInertia $inertia) => $inertia->hasResource($key, $resource)
            );
        });

        TestResponse::macro('assertHasInertiaResourceCollection', function (string $key, ResourceCollection $resource) {
            /** @var TestResponse $this */
            return $this->assertInertia(
                // @phpstan-ignore-next-line
                fn (AssertableInertia $inertia) => $inertia->hasResourceCollection($key, $resource)
            );
        });

        TestResponse::macro('assertHasInertiaPaginatedResource', function (string $key, ResourceCollection $resource) {
            /** @var TestResponse $this */
            return $this->assertInertia(
                // @phpstan-ignore-next-line
                fn (AssertableInertia $inertia) => $inertia->hasPaginatedResource($key, $resource)
            );
        });
    }
}
