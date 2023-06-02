<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Support;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();

        $datas = [
            [
                "user_id" => 1,
            ],
        ];

        Admin::insert($datas);

        Support::truncate();

        $datas = [
            [
                "user_id" => 6,
            ],
        ];

        Support::insert($datas);
    }
}
