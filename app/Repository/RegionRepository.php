<?php

namespace App\Repository;

use App\Exceptions\RegionException;
use Illuminate\Support\Facades\Http;

class RegionRepository
{
    public function getLatLong(string $name)
    {
        $name = last(explode(' ', $name));
        $res = Http::get('https://us1.locationiq.com/v1/search', [
            'key' => config('app.locationiq_key'),
            'format' => 'json',
            'q' => "{$name}-Indonesia",
        ]);

        if (!$res->ok())
            throw new RegionException('Something went wrong with locationiq');

        if (count($res->object()) < 1)
            throw new RegionException('Location not found');

        return $res->object()[0];
    }
}
