<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;

class MapBoxProvider
{
    public function calculateDistance(float $originLat, float $originLng, float $destLat, float $destLng): float {
        $url = "https://api.mapbox.com/directions/v5/mapbox/driving/{$originLng},{$originLat};{$destLng},{$destLat}";
        
        $response = Http::get($url, [
            'access_token' => env('MAPBOX_ACCESS_TOKEN'),
            'geometries' => 'geojson',
        ]);

        $data = $response->json();
        
        return $data['routes'][0]['distance'] / 1000;
    }
}