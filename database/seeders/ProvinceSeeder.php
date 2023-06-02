<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Province;
use Carbon\Carbon;

class ProvinceSeeder extends Seeder
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
        ])->get('https://api.rajaongkir.com/starter/province');

        $provinces =  $response['rajaongkir']['results'];

        foreach ($provinces as $province) {
            $data_province[] = [
                'id' => $province['province_id'],
                'province' => $province['province'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        Province::insert($data_province);
    }

    //function untuk get data province and city
    private function getData($key,$url){
        return Http::withHeaders([
            'key' => $key
        ])->get($url);
    }
}
