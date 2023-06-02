<?php

namespace Database\Seeders;

use App\Models\Education;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Education::truncate();

        $datas = [
            [
                "user_id" => 2,
                "category_education_id" => 1,
                "title" => "Lorem Ipsum",
                "slug" => "lorem-ipsum",
                "date" => Carbon::now()->format('Y-m-d'),
                "file" => "lorem-ipsum.jpg",
                "desc" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged."
            ],
             [
                "user_id" => 2,
                "category_education_id" => 1,
                "title" => "Lorem Ipsum 2",
                "slug" => "lorem-ipsum-2",
                "date" => Carbon::now()->format('Y-m-d'),
                "file" => "lorem-ipsum.jpg",
                "desc" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged."
            ]
        ];

        Education::insert($datas);
    }
}
