<?php

namespace Database\Seeders;

use App\Models\EducationCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EducationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EducationCategory::truncate();

        $datas = [
            [
                "gapoktan_id" => 1,
                "name" => "Pupuk Organik",
                "slug" => "pupuk-organik",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        ];

        EducationCategory::insert($datas);
    }
}
