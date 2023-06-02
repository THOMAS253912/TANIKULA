<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('1234567'),
        ]);

        $admin->assignRole('admin');

        $gapoktan = User::create([
            'name' => 'Gapoktan',
            'email' => 'gapoktan@test.com',
            'password' => bcrypt('1234567'),
        ]);

        $gapoktan->assignRole('gapoktan');

        $poktan = User::create([
            'name' => 'Poktan',
            'email' => 'poktan@test.com',
            'password' => bcrypt('1234567'),
        ]);

        $poktan->assignRole('poktan');

        $petani = User::create([
            'name' => 'Petani',
            'email' => 'petani@test.com',
            'password' => bcrypt('1234567'),
        ]);

        $petani->assignRole('petani');

        $pembeli = User::create([
            'name' => 'Pembeli',
            'email' => 'pembeli@test.com',
            'password' => bcrypt('1234567'),
        ]);

        $pembeli->assignRole('pembeli');

        $support = User::create([
            'name' => 'Support',
            'email' => 'support@test.com',
            'password' => bcrypt('1234567'),
        ]);

        $support->assignRole('support');

    }
}
