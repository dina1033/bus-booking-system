<?php

namespace App\Providers;

use App\Repository\AuthRepository;
use App\Repository\AuthRepositoryInterface;
use App\Repository\BaseRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\ReservationRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SeatRepository;
use App\Repository\SeatRepositoryInterface;
use App\Repository\TripRepository;
use App\Repository\TripRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
        $this->app->bind(TripRepositoryInterface::class, TripRepository::class);
        $this->app->bind(SeatRepositoryInterface::class, SeatRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
