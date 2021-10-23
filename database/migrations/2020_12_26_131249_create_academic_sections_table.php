<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAcademicSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_sections', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });
        DB::table('academic_sections')->insert([
            ['description'=>'Todos'],
            ['description'=>'A'],
            ['description'=>'B'],
            ['description'=>'C'],
            ['description'=>'D'],
            ['description'=>'E']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_sections');
    }
}
