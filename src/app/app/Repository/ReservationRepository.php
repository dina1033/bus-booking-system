<?php

namespace App\Repository;

use App\Models\Reservation;
use App\Repository\ReservationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ReservationRepository extends BaseRepository implements ReservationRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Reservation $model)
    {
        $this->model = $model;
    }

    public function checkUserReservation($trip_id , $user_id) {

        return $this->model->where('trip_id',$trip_id)->where('user_id',$user_id)->first();
    }
    public function getReservedSeats($trip_id){
        return $this->model->where('trip_id',$trip_id)->orderBy('seat_id','asc')->get()->groupBy('seat_id');
    }

    public function addReservation($request,$trip,$seat_id){
        $reservation = $this->model::create([
            'user_id' => $request['user_id'],
            'trip_id' => $trip->id,
            'bus_id' => $trip->bus_id,
            'seat_id' => $seat_id,
            'from_station_id' => $request['from_station_id'],
            'to_station_id' => $request['to_station_id'],
        ]);
        if(!$reservation)
            return ['status' =>false , 'message'=>'sorry there is no available seat'];

        return ['status' =>true , 'message'=>'the seat is successfully reserved.'] ;
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

    public function getUserTrip($user_id){
        return $this->model->where('user_id',$user_id)->value('trip_id');
    }
}
