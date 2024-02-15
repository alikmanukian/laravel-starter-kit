<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);

        if ($response = $this->handleJsonErrors($request, $e, $response)) {
            return $response;
        }

        return $response;
    }

    protected function handleJsonErrors(Request $request, Throwable $e, Response $response): JsonResponse|RedirectResponse|null
    {
        if (! $request->ajax() && ! $request->wantsJson()) {
            return null;
        }

        try {
            $status = $e->statusCode ?? $response->getStatusCode();
        } catch (Throwable) {
            $status = $response->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $class = get_class($e);

        switch ($class) {
            case AuthenticationException::class:
                $status = Response::HTTP_UNAUTHORIZED;
                $message = $e->getMessage() ?: 'Unauthenticated';
                break;
            case NotFoundHttpException::class:
                $status = Response::HTTP_NOT_FOUND;
                $message = $e->getMessage() ?: 'Not found';
                break;
            default:
                $message = $e->getMessage() ?: 'An error occurred';
                break;
        }

        // we put it in cache instead of session to make it available after redirect
        Cache::set('flash.error', ['code' => $status, 'message' => $message], now()->addMinute());

        return $request->inertia()
            ? back()
            : response()->json([
                'error' => [
                    'message' => $message,
                    'code' => $status,
                ],
            ], $status);
    }
}
