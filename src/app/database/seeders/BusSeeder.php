<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Seat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['id' => 1, 'bus_number' => '1'],
            ['id' => 2, 'bus_number' => '2'],
            ['id' => 3, 'bus_number' => '3'],
            ['id' => 4, 'bus_number' => '4'],
            ['id' => 5, 'bus_number' => '5']
        ];

        foreach($items as $item){
            Bus::create($item);
            for($i = 1; $i <= 12 ; $i++){
                Seat::create(['bus_id'=>$item['id']]);
            }
        }
    }
}
