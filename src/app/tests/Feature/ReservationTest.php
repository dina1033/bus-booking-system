<?php

namespace Tests\Feature;

use App\Models\Bus;
use App\Models\Reservation;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_book_seat()
    {
        // Create a bus
        $bus = Bus::create([
            'bus_number' => 1,
        ]);

        // create seat of the bus
        for($i = 1; $i <= 12 ; $i++){
            Seat::create(['bus_id'=>$bus->id]);
        }

        // create stations
        $station1 = Station::create([
            'id'    =>1,
            'name'  => 'Cairo',
        ]);
        $station2 = Station::create([
            'id'    =>2,
            'name'  => 'Giza',
        ]);
        $station3 = Station::create([
            'id'    =>3,
            'name'  => 'AlFayyum',
        ]);
        $station4 = Station::create([
            'id'    =>4,
            'name'  => 'AlMinya',
        ]);
        $station5 = Station::create([
            'id'    =>5,
            'name'  => 'Asyut',
        ]);

        // Create a trip
        $trip = Trip::create([
            'id'=>1,
            'bus_id' => $bus->id,
            'name' => 'trip from cairo to asyout',
            'departure_time' => '2023-04-21 17:32:32',
            'start_station_id' => 1,
            'end_station_id' => 5,
        ]);

        // crate crossover stations of trip
        $trip->stations()->attach([$station1->id => ['order' => 1] , $station2->id => ['order' => 2] , $station3->id => ['order' => 3]
        , $station4->id => ['order' => 4] , $station5->id => ['order' => 5]]);

        $user = User::factory()->create([
            'email' => 'johnne.doa@example.com',
            'password' => bcrypt('password'),
            'mobile_number' => '123455788',
            'name' => 'Johnne Doe',
        ]);
        Sanctum::actingAs($user, ['api']);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->createToken('TestToken')->plainTextToken,
        ])->post('/api/book-seat', [
            'trip_id' => 1,
            'from_station_id' => 1,
            'to_station_id' => 5,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'the seat is successfully reserved.',
        ]);
    }
    public function test_user_cannot_book_another_seat()
    {
        $trip = Trip::first();
        $user = User::first();
        Reservation::create([
            'user_id' => $user->id,
            'trip_id' => $trip->id,
            'bus_id' => $trip->bus_id,
            'seat_id' => 2,
            'from_station_id' =>1 ,
            'to_station_id' => 5,
        ]);
        Sanctum::actingAs($user, ['api']);
        // Make a request to book a seat
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->createToken('TestToken')->plainTextToken,
        ])->post('/api/book-seat', [
            'trip_id' => 1,
            'from_station_id' => 1,
            'to_station_id' => 5,
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'you already have a reservation',
        ]);
    }

    public function test_user_cannot_book_to_not_exist_station_seat()
    {
        $user = User::first();
        Sanctum::actingAs($user, ['api']);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->createToken('TestToken')->plainTextToken,
        ])->post('/api/book-seat', [
            'trip_id' => 1,
            'from_station_id' => 1,
            'to_station_id' => 7,
        ]);

        $response->assertStatus(422);
    }

    public function test_all_seats_on_a_trip_is_reserved()
    {
        $user = User::first();
        $trip = Trip::first();
        for($i = 3; $i <= 12 ; $i++){
            Reservation::create([
                'user_id' => $user->id,
                'trip_id' => $trip->id,
                'bus_id' => $trip->bus_id,
                'seat_id' => $i,
                'from_station_id' =>1 ,
                'to_station_id' => 5,
            ]);
        }
        $new_user = User::factory()->create([
            'email' => 'johnned.dora@example.com',
            'password' => bcrypt('password'),
            'mobile_number' => '133455788',
            'name' => 'Jodhnne Doe',
        ]);
        Sanctum::actingAs($new_user, ['api']);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $new_user->createToken('TestToken')->plainTextToken,
        ])->post('/api/book-seat', [
            'trip_id' => 1,
            'from_station_id' => 1,
            'to_station_id' => 5,
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'sorry there is no available seat',
        ]);
    }

    public function test_available_seats_between_two_stations()
    {
        $user = User::first();

        Sanctum::actingAs($user, ['api']);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->createToken('TestToken')->plainTextToken,
        ])->get('/api/list-available-seat?from_station_id=1&to_station_id=5');

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'sorry there is no available seats between this stations',
        ]);
    }
}
