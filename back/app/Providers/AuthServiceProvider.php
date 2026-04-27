<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Policies\UserPolicy;
use App\Policies\CoursePolicy;
use App\Policies\GradePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Course::class => CoursePolicy::class,
        Enrollment::class => GradePolicy::class,
    ];


    public function boot(): void
    {
        $this->registerPolicies();

        
    }
}
