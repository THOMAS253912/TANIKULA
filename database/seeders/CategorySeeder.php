<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Activity;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $activities = Activity::create([
            'name' => 'Pembagian Sembako',
            'slug' => 'pembagian-sembako',
            'description' => 'Pemerintah memberi bantuan kepada masyarakat berupa sembako',
        ]);

        $categories = Category::create([
            'name' => 'Benih',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'Benjytih',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'jyttj',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'jytjt',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'jytt',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'kfwej',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'bffdre',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'ffbvb ',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'yuky',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'erge',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'Benrhtrrih',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'Behtrnih',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'feweww',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'ewfw',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'fsfew',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'DAwqr',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);

        $categories = Category::create([
            'name' => 'Penda',
            'slug' => 'benih',
            'description' => 'Benih beras',
        ]);
    }
}
