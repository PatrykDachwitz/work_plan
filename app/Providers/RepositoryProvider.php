<?php

namespace App\Providers;

use App\Repository\CalendarCommand;
use App\Repository\UserApi;
use Illuminate\Support\ServiceProvider;
use App\Repository\StatusRepository as StatusRepositoryInterface;
use App\Repository\Eloquent\StatusRepository;
use App\Repository\DayRepository as DayRepositoryInterface;
use App\Repository\Eloquent\DayRepository;
use App\Repository\NotificationRepository as NotificationRepositoryInterface;
use App\Repository\Eloquent\NotificationRepository;
use App\Repository\EventRepository as EventRepositoryInterface;
use App\Repository\Eloquent\EventRepository;
use App\Repository\UserRepository as UserRepositoryInterface;
use App\Repository\Eloquent\UserRepository;
use App\Repository\HistoriesRepository as HistoriesRepositoryInterface;
use App\Repository\Eloquent\HistoriesRepository;


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

        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->singleton(
            UserApi::class,
            UserRepository::class
        );

        $this->app->singleton(
            HistoriesRepositoryInterface::class,
            HistoriesRepository::class
        );

        $this->app->singleton(
            CalendarCommand::class,
            DayRepository::class
        );
    }
}
