<?php

namespace Database\Seeders;

use App\Models\Franchise;
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
            'latitude' => '0',
            'longitude' => '0'
        ]);

        User::create([
            'name' => 'Owner',
            'franchise_id' => '1',
            'email' => 'owner@mail.com',
            'password' => Hash::make('owner123'),
        ])->assignRole('owner');

        User::create([
            'name' => 'admin',
            'franchise_id' => '1',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123')
        ])->assignRole('admin');

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
