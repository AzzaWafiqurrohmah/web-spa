<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = json_decode(file_get_contents(database_path('data/provinces.json')));
        $regencies = json_decode(file_get_contents(database_path('data/regencies.json')));

        Region::insert(array_map(fn ($prov) => [
            'code' => $prov->code,
            'name' => $prov->name,
            'parent' => null,
            'created_at' => now(),
        ], $provinces));

        Region::insert(array_map(fn ($reg) => [
            'code' => $reg->code,
            'name' => $reg->name,
            'parent' => explode('.', $reg->code)[0],
            'created_at' => now(),
        ], $regencies));
    }
}
