<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'gapoktan',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'poktan',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'petani',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'pembeli',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'support',
            'guard_name' => 'web'
        ]);
    }
}
