<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTrainingLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_levels', function (Blueprint $table) {
            $table->string('id')->index();
            $table->string('description');
            $table->timestamps();
        });
        DB::table('training_levels')->insert([
            ['id'=>'PT','description'=>'PROFESIONAL TECNICO']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_levels');
    }
}
