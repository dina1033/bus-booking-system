<?php

namespace Database\Seeders;

use App\Models\Station;
use App\Models\Trip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('trip_stations')->truncate();
        DB::table('reservations')->truncate();

        DB::table('trips')->truncate();
        DB::table('stations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $station1 = Station::create([
            'name' => 'Cairo',
        ]);
        $station2 = Station::create([
            'name' => 'Giza',
        ]);
        $station3 = Station::create([
            'name' => 'AlFayyum',
        ]);
        $station4 = Station::create([
            'name' => 'AlMinya',
        ]);
        $station5 = Station::create([
            'name' => 'Asyut',
        ]);


        $trip = Trip::create([
            'bus_id' => '1',
            'name' => 'trip from cairo to asyout',
            'departure_time' => '2023-04-21 17:32:32',
            'start_station_id' => 1,
            'end_station_id' => 5,
        ]);

        $trip->stations()->attach([$station1->id => ['order' => 1] , $station2->id => ['order' => 2] , $station3->id => ['order' => 3]
        , $station4->id => ['order' => 4] , $station5->id => ['order' => 5]]);
    }
}
