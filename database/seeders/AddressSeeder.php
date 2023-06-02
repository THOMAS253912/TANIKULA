<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::truncate();

        $datas = [
            [
                "user_id" => 5,
                "recipients_name" => "Robert Davids",
                "telp" => "08345839235",
                "address_label" => "Rumah",
                "postal_code" => "45525",
                "complete_address" => "Jl. Rengasdengklok blok dempet Rt 10 Rw 01, Kec Indramayu, Kab Indramayu, Jawa Barat.",
                "note_for_courier" => 'Depan Masjid',
            ],

        ];

        Address::insert($datas);
    }
}
