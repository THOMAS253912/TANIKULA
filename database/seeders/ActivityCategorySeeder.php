<?php

namespace Database\Seeders;

use App\Models\ActivityCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ActivityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActivityCategory::truncate();

        $datas = [
            [
                "gapoktan_id" => 1,
                "name" => "Kategori Kegiatan 1",
                "slug" => "kategori-kegiatan-1",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                "gapoktan_id" => 1,
                "name" => "Kategori Kegiatan 2",
                "slug" => "kategori-kegiatan-2",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        ActivityCategory::insert($datas);
    }
}
