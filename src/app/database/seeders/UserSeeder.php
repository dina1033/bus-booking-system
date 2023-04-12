<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        User::create([
            'name' => 'dina abdallah',
            'email' => 'dina@example.com',
            'mobile_number' => '01094838519',
            'password' => Hash::make('password')
        ]);
    }
}
