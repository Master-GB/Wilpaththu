<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
   ->withMiddleware(function (Middleware $middleware): void {

    $middleware->alias([
        'role' => RoleMiddleware::class,
        'permission' => PermissionMiddleware::class,
        'role_or_permission' => RoleOrPermissionMiddleware::class,
    ]);

})
    ->withExceptions(function (Exceptions $exceptions): void {

    $exceptions->shouldRenderJsonWhen(
        fn (Request $request) => $request->is('api/*'),
    );

    $exceptions->render(function (\App\Exceptions\ApiException $e, Request $request) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'data' => null,
            'errors' => $e->getErrors(),
            'meta' => null,
        ], $e->getStatus());

    });

    $exceptions->render(function (\Illuminate\Validation\ValidationException $e, Request $request) {

        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'data' => null,
            'errors' => $e->errors(),
            'meta' => null,
        ], 422);

    });

    $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, Request $request) {

        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated.',
            'data' => null,
            'errors' => null,
            'meta' => null,
        ], 401);

    });

    $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, Request $request) {

        return response()->json([
            'success' => false,
            'message' => 'Resource not found.',
            'data' => null,
            'errors' => null,
            'meta' => null,
        ], 404);

    });

    $exceptions->render(function (\Illuminate\Auth\Access\AuthorizationException $e, Request $request) {

        return response()->json([
            'success' => false,
            'message' => 'This action is unauthorized.',
            'data' => null,
            'errors' => null,
            'meta' => null,
        ], 403);

    });

    $exceptions->render(function (\Throwable $e, Request $request) {

        return response()->json([
            'success' => false,
            'message' => config('app.debug')
                ? $e->getMessage()
                : 'Internal server error.',
            'data' => null,
            'errors' => null,
            'meta' => null,
        ], 500);

    });

})->create();
