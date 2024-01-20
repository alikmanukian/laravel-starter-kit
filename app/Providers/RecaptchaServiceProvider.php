<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RecaptchaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('recaptcha', static function () {
            return <<<'HTML'
                <?php if (config('services.recaptcha.enabled')) : ?>
                    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.key') }}"></script>
                    <script>window.recaptchaEnabled = true;</script>
                <?php endif; ?>

                <script>
                    window.recaptcha = function (action) {
                        if (window.recaptchaEnabled) {
                            return new Promise((resolve) => {
                                grecaptcha.ready(function () {
                                    grecaptcha.execute('{{ config('services.recaptcha.key') }}', { action: action }).then(function (token) {
                                        resolve(token)
                                    })
                                })
                            })
                        }

                        return Promise.resolve('')
                    }
                </script>
            HTML;
        });
    }
}
