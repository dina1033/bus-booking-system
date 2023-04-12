<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Seat;
use App\Models\Trip;
use App\Service\ReservationService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends ApiController
{
    private $reservation;

    public function __construct(ReservationService $reservation)
    {
        $this->reservation = $reservation;
    }

    public function bookSeat(Request $request){
        $data = $request->merge(['user_id' =>$request->user()->id]);

        $response = $this->reservation->bookSeat($data->all());
        if($response['status'] == false)
            return $this->failure($response['message']);

        return $this->success($response['message']);
    }

    public function listAvailableSeats(Request $request){
        $data = $request->merge(['user_id' =>$request->user()->id]);
        $response = $this->reservation->listAvailableSeats($data->all());

        if(count($response) == 0 )
            return $this->failure('sorry there is no available seats between this stations');

        return $this->successWithData('there is a list of the number of available seats',$response);
    }
}
