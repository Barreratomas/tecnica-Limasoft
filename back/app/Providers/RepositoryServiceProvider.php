<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;
use App\Repositories\Interfaces\GradeRepositoryInterface;

use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\CourseRepository;
use App\Repositories\Eloquent\EnrollmentRepository;
use App\Repositories\Eloquent\GradeRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Enlaza interfaces de repositorio a sus implementaciones concretas (Eloquent)
     * El contenedor usará estas implementaciones cuando se inyecten las interfaces
     */
    public function register(): void
    {
        // Inyección de dependencias: interfaz => implementación Eloquent
        // Cuando un controlador/servicio necesite la interfaz, se inyectará la clase Eloquent
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(EnrollmentRepositoryInterface::class, EnrollmentRepository::class);
        $this->app->bind(GradeRepositoryInterface::class, GradeRepository::class);
    }
    
    /**
     * Para tests: reemplaza un binding con un mock usando:
     *   $this->app->instance(CourseRepositoryInterface::class, $mockInstance);
     */
}