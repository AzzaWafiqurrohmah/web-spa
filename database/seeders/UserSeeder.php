<?php

namespace Database\Seeders;

use App\Models\Franchise;
use App\Models\Setting;
use App\Models\Therapist;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Franchise::create([
            'name' => 'jember',
            'raw_id' => '35.74',
            'latitude' => '-8.158757309001139',
            'longitude' => '113.72444211779218'
        ]);

        User::create([
            'name' => 'Owner',
            'email' => 'owner@mail.com',
            'password' => Hash::make('owner123'),
        ])->assignRole('owner');

        User::create([
            'name' => 'admin',
            'franchise_id' => '1',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123')
        ])->assignRole('admin');

        Setting::insert([
            [
                'user_id' => 2,
                'key' => 'biaya_transport',
                'value' => '10000'
            ],
            [
                'user_id' => 2,
                'key' => 'biaya_ekstra_malam',
                'value' => '10000'
            ],
            [
                'user_id' => 2,
                'key' => 'uang_makan',
                'value' => '12000'
            ]
        ]);

        Therapist::create([
            'email' => 'therapist@mail.com',
            'password' => Hash::make('therapist123'),
            'fullname' => 'Terapis',
            'birth_date' => fake()->date,
            'gender' => 'male',
            'phone' => '081234567890',
            'address' => fake()->address,
            'body_height' => '160',
            'body_weight' => '50',
            'start_working' => now(),
            'franchise_id' => '1'
        ])->assignRole('therapist');
    }
}
