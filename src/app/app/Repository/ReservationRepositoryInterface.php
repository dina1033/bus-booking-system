<?php

namespace App\Repository;

interface ReservationRepositoryInterface extends EloquentRepositoryInterface
{
    public function checkUserReservation($trip_id , $user_id);
    public function getReservedSeats($trip_id);
    public function addReservation($request,$trip,$seat_id);
    public function getUserTrip($user_id);
}
