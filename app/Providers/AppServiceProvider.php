<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\EmployeeRepository;
use App\Interfaces\FeedbackRepositoryInterface;
use App\Repositories\FeedbackRepository;
use App\Interfaces\ProjectRepositoryInterface;
use App\Repositories\ProjectRepository;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
    $this->app->bind(FeedbackRepositoryInterface::class, FeedbackRepository::class);
    $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);

}

    

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
