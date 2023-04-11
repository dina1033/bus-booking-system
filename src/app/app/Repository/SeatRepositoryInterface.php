<?php

namespace App\Repository;

interface SeatRepositoryInterface extends EloquentRepositoryInterface
{
    public function getAvailableSeats($trip);
    public function getBusSeats($trip);
}
