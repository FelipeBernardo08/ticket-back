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
            "name",
            "fone" => '17991020668',
            "cnpj" => '2318907398172',
            "date_born" => '08-09-1998',
            "id_user" => 1
        ]);
    }
}
