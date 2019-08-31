<?php

namespace App\Providers;

use App\Models\ScheduleSession;
use App\Observers\ScheduleSessionObserver;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Resource::withoutWrapping();

        ScheduleSession::observe(ScheduleSessionObserver::class);
    }
}
