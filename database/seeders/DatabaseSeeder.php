<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            // ActivityCategorySeeder::class,
            ProvincesSeeder::class,
            CitiesSeeder::class,
            DistrictsSeeder::class,
            VillagesSeeder::class,
            ActivitySeeder::class,
            EducationCategorySeeder::class,
            EducationSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ProductCategorySeeder::class,
            GapoktanSeeder::class,
            PoktanSeeder::class,
            FarmerSeeder::class,
            ProductSeeder::class,
            CostumerSeeder::class,
            AddressSeeder::class,
            AdminSeeder::class,
            FieldSeeder::class,
            // ProvinceSeeder::class,
            // CitySeeder::class,
        ]);

        // $this->call(CategorySeeder::class);
    }
}
