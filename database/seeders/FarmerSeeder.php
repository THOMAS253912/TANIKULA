<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Farmer;
use Carbon\Carbon;

class FarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Farmer::truncate();

        $datas = [
            [
                "user_id" => 4,
                "gapoktan_id" => 1,
                "poktan_id" => 1,
                "is_active" => 1,
                'created_at' => Carbon::now()->format('Y-m-d'),
                'updated_at' => Carbon::now()->format('Y-m-d'),
            ],
        ];

        Farmer::insert($datas);
    }
}
