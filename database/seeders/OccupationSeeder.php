<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('occupations')->insert([
            ['description'=>'Electricista'],
            ['description'=>'Carpintero'],
            ['description'=>'Pintor'],
            ['description'=>'Plomero'],
            ['description'=>'Practicante'],
            ['description'=>'Ayudante'],
            ['description'=>'Soldador'],
            ['description'=>'Chapero'],
            ['description'=>'Vidriero'],
            ['description'=>'Recepcionista']
        ]);
    }
}
