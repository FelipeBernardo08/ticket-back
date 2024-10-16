<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            "email" => "bernardodev0809@gmail.com",
            "password" => bcrypt('123'),
            "id_permission" => 2,
            "auth" => 'approved'
        ]);
    }
}
