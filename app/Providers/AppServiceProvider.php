<?php

namespace App\Providers;

use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\UserRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerAppConfigs();

        $this->registerRepositories();

        $this->registerServices();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Remove data wrap from json resource
        JsonResource::withoutWrapping();
    }

    private function registerAppConfigs(): void
    {
        // Set max length for mysql db
        Schema::defaultStringLength(191);

        // For https scheme if not on local machine
        if(config('app.env') !== 'local'){
            URL::forceScheme('https');
        }

    }

    private function registerServices(): void
    {
        /**
         * ==================================================
         * Security Related Interface bindings
         * =================================================
         */

    }

    private function registerRepositories(): void
    {
        /**
         * ==================================================
         * Repository Interface bindings
         * =================================================
         */
        $this->app->singleton(UserRepositoryContract::class, UserRepository::class);
    }
}
