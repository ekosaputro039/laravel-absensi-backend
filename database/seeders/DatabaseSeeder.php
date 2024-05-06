<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Eko Saputro',
            'email' => 'eko@fic16.com',
            'password' => Hash::make('12345678'),
        ]);

        \App\Models\Company::create([
            'name' =>'UPT TUBAN',
            'email' =>'upt@gmail.com',
            'address' => 'Jl. Mojopahit NO.100 Sidorejo Kec. Tuban Kab. Tuban',
            'latitude' => '-7.747833',
            'longitude' => '110.355398',
            'radius_km' => '0.5',
            'time_in' => '07:00',
            'time_out' => '17:00',
        ]);

        $this->call([
            AttendanceSeeder::class,
        ]);
    }
}
