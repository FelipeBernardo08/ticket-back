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
            'email' => 'adm@gmail.com',
            'name' => 'adm',
            'fone' => '000000',
            'cpf' => '000000',
            'date_born' => '2024-09-08',
            'id_permission' => 2,
            'password' => bcrypt('adm123')
        ]);
    }
}
