<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;


use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Request as HttpRequest;

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->api(prepend: [
        //     EnsureFrontendRequestsAreStateful::class,
        // ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, HttpRequest $request) {
            // // Only handle API requests
            // if (!$request->is('api/*') && !$request->expectsJson()) {
            //     return null; // Let default handler take over for web routes
            // }
            // Map exceptions to responses

            return match ($request->is('api/*') || $request->expectsJson()) {
                // 401 - Unauthenticated
                $e instanceof AuthenticationException =>
                apiError(__('message.exception.authentication.message'), __('message.exception.authentication.error'), __('message.exception.authentication.code')),

                // 422 - Validation Error
                $e instanceof ValidationException =>
                apiError(__('message.exception.validation.message'), __('message.exception.validation.error'), __('message.exception.validation.code'), [
                    'errors' => $e->errors(),
                ]),

                // 403 - Forbidden
                $e instanceof AuthorizationException =>
                apiError(__('message.exception.authorization.message'), __('message.exception.authorization.message'), __('message.exception.authorization.message')),

                // 404 - Model Not Found
                $e instanceof ModelNotFoundException =>
                apiError(__('message.exception.model_not_found.message'), __('message.exception.model_not_found.message'), __('message.exception.model_not_found.message')),

                // 404 - Route Not Found
                $e instanceof NotFoundHttpException =>
                apiError(__('message.exception.route_not_found.message'), __('message.exception.route_not_found.message'), __('message.exception.route_not_found.message')),

                // 405 - Wrong HTTP Method
                $e instanceof MethodNotAllowedHttpException =>
                apiError(__('message.exception.method_not_allowed.message'), __('message.exception.method_not_allowed.message'), __('message.exception.method_not_allowed.message'), [
                    'allowed_methods' => $e->getHeaders()['Allow'] ?? null,
                ]),

                // Generic HTTP Exceptions
                $e instanceof HttpException =>
                apiError(
                    $e->getMessage() ?: __('message.exception.http_exception.message'),
                    $e->getMessage(),
                    $e->getStatusCode()
                ),

                // DEFAULT: Catch-All Handler
                default => apiError(
                    config('app.debug') ? $e->getMessage() : 'Internal server error',
                    config('app.debug') ? get_class($e) : 'Unexpected error',
                    guessStatus($e),
                    config('app.debug') ? [
                        'trace' => $e->getTraceAsString(),
                        'file'  => $e->getFile(),
                        'line'  => $e->getLine(),
                    ] : []
                )
            };
        });
    })->create();
