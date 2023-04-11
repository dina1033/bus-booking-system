<?php

namespace App\Repository;

use App\Models\Seat;
use App\Repository\SeatRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SeatRepository extends BaseRepository implements SeatRepositoryInterface
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
    public function __construct(Seat $model)
    {
        $this->model = $model;
    }

    public function getAvailableSeats($trip){
        return $this->model->WhereDoesntHave('reservations',function($q)use($trip){
            $q->where('trip_id',$trip->id);
            })->where('bus_id',$trip->bus_id)->select('id')
        ->get();
    }
    public function getBusSeats($trip){
        return $this->model->where('bus_id', $trip->bus_id)->select('id')->orderBy('id','asc')->pluck('id')->toArray();
    }




}
