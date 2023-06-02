<?php

namespace Database\Seeders;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();

        $datas = [
            [
                "name" => "Beras Organik",
                "slug" => "beras-organik",
                "image" => "image.jpg",
                "category_product_id" => 1,
                "code" => "1234",
                "stoke" => 6,
                "weight" => 1500,
                "price" => 100000,
                "desc" => "Ini adalah contoh kalimat untuk deskripsi",
                "user_id" => 2,
                "is_active" => true,
                'created_at' => Carbon::now()->format('Y-m-d'),
                'updated_at' => Carbon::now()->format('Y-m-d'),
            ],
            [
                "name" => "Beras Organik 2",
                "slug" => "beras-organik-2",
                "image" => "image.jpg",
                "category_product_id" => 1,
                "code" => "1235",
                "stoke" => 6,
                "weight" => 2500,
                "price" => 1000000,
                "desc" => " 2 Ini adalah contoh kalimat untuk deskripsi",
                "user_id" => 2,
                "is_active" => true,
                'created_at' => Carbon::now()->format('Y-m-d'),
                'updated_at' => Carbon::now()->format('Y-m-d'),
            ],
        ];
        Product::insert($datas);
    }
}
