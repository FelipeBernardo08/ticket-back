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
            "name" => "ADM",
            "fone" => "17991838456",
            "cnpj" => "0000001-00",
            "date_born" => "08-09-2024",
            "id_user" => 1
        ]);
    }
}
