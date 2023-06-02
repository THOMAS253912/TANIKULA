<?php

namespace Database\Seeders;
use App\Models\Poktan;

use Illuminate\Database\Seeder;

class PoktanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Poktan::truncate();

        $datas = [
            [
                "user_id" => 3,
                "gapoktan_id" => 1,
                "chairman" => "Bapak Mara",
                "is_active" => 1,
            ],
        ];

        Poktan::insert($datas);
    }
}
