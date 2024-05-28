<?php

namespace App\Repository\owner;

use Illuminate\Support\Facades\Http;

class FranchiseRepository
{

    public static function getCity()
    {
        $response = Http::get(
            'https://sipedas.pertanian.go.id/api/wilayah/list_wilayah?thn=2024&lvl=10&lv2=12'
        );
        return $response->json();
    }

    public static function getLatLng(string $city)
    {
        $response = Http::get(
            'https://us1.locationiq.com/v1/search?key=pk.8020900827a93b0d5fed04b4ee3c6dc4&q='. $city .'&format=json&',
        );
        return $response->json()[0];
    }
}
