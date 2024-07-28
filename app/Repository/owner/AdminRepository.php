<?php

namespace App\Repository\owner;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminRepository
{
    public static function save(array $data)
    {
        $admin = User::create([
            'name' => $data['name'],
            'franchise_id' => $data['franchise_id'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
        $admin->assignRole('admin');

        Setting::insert([
            [
                'user_id' => $admin->id,
                'key' => 'uang_makan',
                'value' => $data['uang_makan']
            ],
            [
                'user_id' => $admin->id,
                'key' => 'biaya_ekstra_malam',
                'value' => $data['biaya_ekstra_malam']
            ],
            [
                'user_id' => $admin->id,
                'key' => 'biaya_transport',
                'value' => $data['biaya_transport']
            ]
        ]);

        return $admin;
    }

    public static function update(User $user, array $data)
    {
        if(is_null($data['password'] ?? null)) unset($data['password']);

        if(isset($data['password'])) $data['password'] = Hash::make($data['password']);

        $user->update($data);

        Setting::query()
            ->where('user_id', $user->id)
            ->delete();

        Setting::insert([
            [
                'user_id' => $user->id,
                'key' => 'uang_makan',
                'value' => $data['uang_makan']
            ],
            [
                'user_id' => $user->id,
                'key' => 'biaya_ekstra_malam',
                'value' => $data['biaya_ekstra_malam']
            ],
            [
                'user_id' => $user->id,
                'key' => 'biaya_transport',
                'value' => $data['biaya_transport']
            ]
        ]);

    }
}
