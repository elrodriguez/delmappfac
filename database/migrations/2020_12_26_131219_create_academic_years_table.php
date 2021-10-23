<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAcademicYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });
        DB::table('academic_years')->insert([
            ['description'=>'1ro'],
            ['description'=>'2do'],
            ['description'=>'3ro'],
            ['description'=>'4to'],
            ['description'=>'5to'],
            ['description'=>'6to']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_years');
    }
}
