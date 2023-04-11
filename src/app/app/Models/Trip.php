<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function stations(){
        return $this->belongsToMany(Station::class , 'trip_stations')->withPivot('order');
    }
}
