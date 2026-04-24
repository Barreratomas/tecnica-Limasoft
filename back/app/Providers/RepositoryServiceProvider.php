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
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(EnrollmentRepositoryInterface::class, EnrollmentRepository::class);
        $this->app->bind(GradeRepositoryInterface::class, GradeRepository::class);
    }
}