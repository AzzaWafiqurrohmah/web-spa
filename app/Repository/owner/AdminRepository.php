<?php

namespace App\Repository\owner;

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
        return $admin;
    }

    public static function update(User $user, array $data)
    {
        if(is_null($data['password'] ?? null)) unset($data['password']);

        if(isset($data['password'])) $data['password'] = Hash::make($data['password']);

        $user->update($data);
    }
}
