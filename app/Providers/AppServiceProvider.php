<?php

namespace App\Providers;

use App\Models\ScheduleSession;
use App\Observers\ScheduleSessionObserver;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
