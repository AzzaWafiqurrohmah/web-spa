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
        User::create([
            'name' => 'Owner',
            'email' => 'owner@mail.com',
            'password' => Hash::make('owner123'),
        ])->assignRole('owner');

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123')
        ])->assignRole('admin');

        Franchise::factory()->create()->therapist()->create([
            'raw_id' => '1234567890',
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
        ])->assignRole('therapist');
    }
}
