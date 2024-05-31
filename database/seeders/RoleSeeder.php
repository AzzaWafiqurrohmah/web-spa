<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'owner']);
        $admin = Role::create(['name' => 'admin']);

        $therapist = Role::create([
            'name' => 'therapist',
            'guard_name' => 'therapist'
        ]);

        $admin->givePermissionTo(['crud treatments', 'crud customers']);
    }
}
