<?php

namespace App\Http\Middleware;

use App\Exceptions\RecaptchaRequestFailed;
use App\Exceptions\RecaptchaVerificationFailed;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifyRecaptchaToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     *
     * @throws RecaptchaRequestFailed
     * @throws RecaptchaVerificationFailed
     */
    public function handle(Request $request, Closure $next, ?float $score = null): Response
    {
        $response = Http::asForm()
            ->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret'),
                'response' => $request->recaptcha_token,
                'remoteip' => $request->ip(),
            ])
            ->object();

        if (! $response || $response->success === false) {
            throw new RecaptchaRequestFailed();
        }

        if ($response->score < $score ?? config('services.recaptcha.score')) {
            throw new RecaptchaVerificationFailed();
        }

        return $next($request);
    }
}
