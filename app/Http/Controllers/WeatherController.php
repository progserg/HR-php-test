<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function index()
    {
        $weather = Cache::remember('weather',
            now()->addSeconds(300),
            function () {
                $client = new Client();
                $response = $client->get('http://api.openweathermap.org/data/2.5/weather', [
                    'query' => [
                        'id' => 571476,
                        'APPID' => 'c0e4325e9c73261f1a6144f76ebf9147',
                        'units' => 'metric',
                    ]
                ]);
                $response = json_decode($response->getBody());
                return round($response->main->temp, 0);
            });

        return view('weather', [
            'weather' => $weather,
        ]);
    }
}
