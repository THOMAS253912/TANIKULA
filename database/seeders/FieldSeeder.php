<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Field;
use App\Models\FieldCategory;
use Carbon\Carbon;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FieldCategory::truncate();

        $datas = [
            [
                "gapoktan_id" => 1,
                "name" => 'Sawah',
                "details" => 'Padi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "gapoktan_id" => 1,
                "name" => 'Kebun',
                "details" => 'Jagung',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        FieldCategory::insert($datas);

        Field::truncate();

        $datas = [
            [
                "field_category_id" => 1,
                "gapoktan_id" => 1,
                "farmer_id" => 1,
                "status" => 'Belum ada status',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "field_category_id" => 2,
                "gapoktan_id" => 1,
                "farmer_id" => 1,
                "status" => 'Belum ada status',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        Field::insert($datas);
    }
}
