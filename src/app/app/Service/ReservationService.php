<?php

namespace App\Service;

use App\Repository\ReservationRepositoryInterface;
use App\Repository\SeatRepositoryInterface;
use App\Repository\TripRepositoryInterface;
use App\Service\BaseService;

class ReservationService extends BaseService
{
    protected $repo;
    protected $trip;
    protected $seat;
    public function __construct(ReservationRepositoryInterface $repo , TripRepositoryInterface $trip , SeatRepositoryInterface $seat)
    {
        $this->repo = $repo;
        $this->trip = $trip;
        $this->seat = $seat;
    }

    function checkValidations($trip ,$data){
        $stations = $trip->stations->pluck('id')->toArray();
        if (!in_array($data['from_station_id'], $stations) || !in_array($data['to_station_id'], $stations))
            return ['status' =>false , 'message'=>'sorry this stations is not in this trip'];


        $user_reservation = $this->repo->checkUserReservation($data['trip_id'] , $data['user_id']);
        if($user_reservation)
            return ['status' =>false , 'message'=>'you already have a reservation'];

        return ['status'=>true];
    }

    function bookSeat(array $data){
        $trip = $this->trip->findById($data['trip_id'],['*'],['stations']);
        $validations = $this->checkValidations($trip ,$data);
        if($validations['status'] !=true)
            return $validations;

        $reserved_seats = $this->repo->getReservedSeats($data['trip_id']);
        $available_seats = $this->seat->getAvailableSeats($trip);
        if(count($available_seats) > 0){
            $seat = $available_seats->first();
            return $this->repo->addReservation($data,$trip,$seat->id);
        }else{
            foreach($reserved_seats as $key=>$seat){
               if($this->checkAvailability($seat,$data))
                    return $this->repo->addReservation($data,$trip,$key);
            }
            return ['status' =>false , 'message'=>'sorry there is no available seat'];
        }
    }

    function listAvailableSeats(array $data){
        $trip_id = $this->repo->getUserTrip($data['user_id']);
        if(!$trip_id)
            return ['status'=>false , 'message'=>'sorry this is not your trip you can book a seat and try again'];
        $trip = $this->trip->findById($trip_id);
        $reserved_seats = $this->repo->getReservedSeats($trip_id);
        $available=[];
        if(count($reserved_seats) == 0){
            return ['status'=>true , 'data'=>array_unique($this->seat->getBusSeats($trip))];
        }
        foreach($reserved_seats as $key=>$seat){
            if($this->checkAvailability($seat,$data)){
                $available[]=$key;
            }
        }
        return ['status'=>true , 'data'=>array_unique($available)];
    }

    public function checkAvailability($seat , $data){
        foreach($seat as $seat_reservation){
            if($seat_reservation->to_station_id <= $data['from_station_id'] || $seat_reservation->from_station_id >= $data['to_station_id'] ){
                continue;
            }else{
                return false;
            }
        }
        return true;
    }
}
