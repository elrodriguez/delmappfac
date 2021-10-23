<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateResolutionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resolution_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->string('description');
            $table->timestamps();
        });
        DB::table('resolution_types')->insert([
            ['id'=>'RLA','description'=> 'Resolución de licenciamiento y/o autorización (tipo, número y fecha)'],
            ['id'=>'RRR','description'=> 'Resolución de renovación y/o revalidación (tipo, número y fecha)']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resolution_types');
    }
}
