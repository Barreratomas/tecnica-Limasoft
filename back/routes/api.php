<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\CourseController;
// use App\Http\Controllers\EnrollmentController;
// use App\Http\Controllers\GradeController;
// use App\Http\Controllers\UserController;

// Rutas públicas
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });

    // Cursos
    // Route::apiResource('courses', CourseController::class);
    // Route::get('courses/{course}/students', [EnrollmentController::class, 'students']);
    // Route::post('courses/{course}/enroll', [EnrollmentController::class, 'enroll']);

    // // Matrículas
    // Route::delete('enrollments/{enrollment}', [EnrollmentController::class, 'destroy']);

    // // Notas
    // Route::get('enrollments/{enrollment}/grade', [GradeController::class, 'show']);
    // Route::put('enrollments/{enrollment}/grade', [GradeController::class, 'update']);

    // // Usuarios
    // Route::apiResource('users', UserController::class)->except(['destroy']);
});