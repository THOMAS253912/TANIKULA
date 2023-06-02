<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\City;
use Carbon\Carbon;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::withHeaders([
            'key' => 'f5ed16cb52b0f2936e98e7e22a4a02f5'
        ])->get('https://api.rajaongkir.com/starter/city');

        $cities =  $response['rajaongkir']['results'];

        foreach ($cities as $city) {
            $data_city[] = [
                'id' => $city['city_id'],
                'province_id' => $city['province_id'],
                'type' => $city['type'],
                'city_name' => $city['city_name'],
                'postal_code' => $city['postal_code'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        City::insert($data_city);
    }
}
