<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    public function index()
    {
        // $response = Http::withHeaders([
        //     'key' => 'f5ed16cb52b0f2936e98e7e22a4a02f5'
        // ])->get('https://api.rajaongkir.com/starter/province');
        // return $response['rajaongkir']['results'];

        $response = Http::withHeaders([
            'key' => 'f5ed16cb52b0f2936e98e7e22a4a02f5'
        ])->get('https://api.rajaongkir.com/starter/city');
        return $response['rajaongkir']['results'];

        // $origin = 501;
        // $destination = 114;
        // $weight = 1700;
        // $courier = "jne";
        // $service = 1;

        // $response = Http::asForm()->withHeaders([
        //     'key' => 'f5ed16cb52b0f2936e98e7e22a4a02f5'
        // ])->post('https://api.rajaongkir.com/starter/cost', [
        //     'origin' => $origin,
        //     'destination' => $destination,
        //     'weight' => $weight,
        //     'courier' => $courier,
        // ]);

        // return $response['rajaongkir']['results'][0]['costs'][$service];
    }
}
