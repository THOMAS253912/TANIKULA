<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::truncate();

        $datas = [
            [
                "gapoktan_id" => 1,
                "name" => "Beras",
                "slug" => "beras",
                "is_active" => 1,
            ],
            [
                "gapoktan_id" => 1,
                "name" => "Buah",
                "slug" => "buah",
                "is_active" => 1,
            ],
            [
                "gapoktan_id" => 1,
                "name" => "Olahan Buah",
                "slug" => "olahan-ouah",
                "is_active" => 1,
            ],
            [
                "gapoktan_id" => 1,
                "name" => "Bibit Sayuran",
                "slug" => "bibit-sayuran",
                "is_active" => 1,
            ],
            [
                "gapoktan_id" => 1,
                "name" => "Sayuran",
                "slug" => "sayuran",
                "is_active" => 1,
            ],
            [
                "gapoktan_id" => 1,
                "name" => "Roti",
                "slug" => "roti",
                "is_active" => 1,
            ],
            [
                "gapoktan_id" => 1,
                "name" => "Jamu Herbal",
                "slug" => "jamu-herbal",
                "is_active" => 1,
            ],
            [
                "gapoktan_id" => 1,
                "name" => "Susu Kedelai",
                "slug" => "susu-kedelai",
                "is_active" => 1,
            ],
        ];

        ProductCategory::insert($datas);
    }
}
