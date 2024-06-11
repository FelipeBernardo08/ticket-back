<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryRegistre extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'name' => 'Cliente'
            ],
            [
                'name' => 'ADM'
            ],
            [
                'name' => 'Gerente'
            ],
            [
                'name' => 'Funcionário'
            ]
        ]);
    }
}
