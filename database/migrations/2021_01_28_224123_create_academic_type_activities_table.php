<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAcademicTypeActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_type_activities', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
        DB::table('academic_type_activities')->insert([
            ['description' =>'Contenido','state' => 1],
            ['description' =>'Foro','state' => 1],
            ['description' =>'Examen','state' => 1],
            ['description' =>'Pregunta','state' => 1],
            ['description' =>'Tarea','state' => 1],
            ['description' =>'Video','state' => 1],
            ['description' =>'Archivo','state' => 1]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_type_activities');
    }
}
