<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ADMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profile_adms')->insert([
            "name" => 'Felipe Bernardo (ADM)',
            "fone" => '17991020668',
            "cnpj" => '55599829000144',
            "date_born" => '2024-08-01',
            "id_user" => 1
        ]);
    }
}
