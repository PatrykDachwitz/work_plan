<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\StatusRepository as StatusRepositoryInterface;
use App\Repository\Eloquent\StatusRepository;
use App\Repository\DayRepository as DayRepositoryInterface;
use App\Repository\Eloquent\DayRepository;


class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            StatusRepositoryInterface::class,
            StatusRepository::class
        );

        $this->app->singleton(
            DayRepositoryInterface::class,
            DayRepository::class
        );
    }
}
