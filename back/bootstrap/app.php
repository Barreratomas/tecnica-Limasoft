<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
   ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return response()->json([
                'message' => 'No autenticado.',
            ], 401);
        });

        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            return response()->json([
                'message' => 'No tenés permisos para realizar esta acción.',
            ], 403);
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            return response()->json([
                'message' => 'No tenés permisos para realizar esta acción.',
            ], 403);
        });

        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            return response()->json([
                'message' => 'Recurso no encontrado.',
            ], 404);
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors'  => $e->errors(),
            ], 422);
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            return response()->json([
                'message' => 'Error interno del servidor.',
            ], 500);
        });

    })->create();
