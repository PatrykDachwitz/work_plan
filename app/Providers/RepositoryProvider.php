<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\StatusRepository as StatusRepositoryInterface;
use App\Repository\Eloquent\StatusRepository;
use App\Repository\DayRepository as DayRepositoryInterface;
use App\Repository\Eloquent\DayRepository;
use App\Repository\NotificationRepository as NotificationRepositoryInterface;
use App\Repository\Eloquent\NotificationRepository;
use App\Repository\EventRepository as EventRepositoryInterface;
use App\Repository\Eloquent\EventRepository;


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
        $this->app->singleton(
            StatusRepositoryInterface::class,
            StatusRepository::class
        );

        $this->app->singleton(
            DayRepositoryInterface::class,
            DayRepository::class
        );

        $this->app->singleton(
            NotificationRepositoryInterface::class,
            NotificationRepository::class
        );

        $this->app->singleton(
            EventRepositoryInterface::class,
            EventRepository::class
        );
    }
}
