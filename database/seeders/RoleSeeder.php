<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => "admin",
        ]);

        DB::table('roles')->insert([
            'name' => "kassamedewerker",
        ]);

        DB::table('roles')->insert([
            'name' => "serveerster",
        ]);
        DB::table('roles')->insert([
            'name' => "user",
        ]);
    }
}
