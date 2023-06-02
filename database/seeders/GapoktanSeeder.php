<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gapoktan;
use App\Models\UserGapoktan;
use App\Models\CertificateGapoktan;

class GapoktanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gapoktan::truncate();

        $datas = [
            [
                "user_id" => 2,
                "chairman" => "Bapak Mara",
                "is_verified" => 1,
            ],
        ];

        Gapoktan::insert($datas);

        UserGapoktan::truncate();

        $datas = [
            [
                "user_id" => 2,
                "gapoktan_id" => 1,
                "is_active" => 1,
            ],
        ];

        UserGapoktan::insert($datas);

        CertificateGapoktan::truncate();

        $datas = [
            [
                "gapoktan_id" => 1,
                "evidence" => "akta.jpg",
            ],
        ];

        CertificateGapoktan::insert($datas);
    }
}
