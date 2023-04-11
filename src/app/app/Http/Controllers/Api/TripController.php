<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TripResource;
use App\Models\Trip;
use App\Service\TripService;
use Illuminate\Http\Request;

class TripController extends ApiController
{
    private $trip;

    public function __construct(TripService $trip)
    {
        $this->trip = $trip;
    }

    public function getTrips(){
        $trips = TripResource::collection($this->trip->allTrips(['*'] , ['bus','fromStation','toStation']));
        if(count($trips) == 0)
            return $this->failure('sorry there is no available trips');

        return $this->successWithData('there is a list of all trips',$trips);
    }
}
