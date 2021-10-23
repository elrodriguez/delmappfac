<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePersonTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });
        DB::table('person_types')->insert([
            ['description'=>'Cliente'],
            ['description'=>'Proveedor'],
            ['description'=>'Empleado'],
            ['description'=>'Docente'],
            ['description'=>'Alumno']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_types');
    }
}
