<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function stations(){
        return $this->belongsToMany(Station::class ,'trip_stations')->withPivot('order');
    }
    public function bus(){
        return $this->belongsTo(Bus::class)->select('id','bus_number');
    }
    public function fromStation(){
        return $this->belongsTo(Station::class,'start_station_id')->select('id','name');
    }
    public function toStation(){
        return $this->belongsTo(Station::class,'end_station_id')->select('id','name');
    }
}

