<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stations')->truncate();
        Station::create([
            'name' => 'Cairo',
        ]);
        Station::create([
            'name' => 'Giza',
        ]);
        Station::create([
            'name' => 'AlFayyum',
        ]);
        Station::create([
            'name' => 'AlMinya',
        ]);
        Station::create([
            'name' => 'Asyut',
        ]);
    }
}
