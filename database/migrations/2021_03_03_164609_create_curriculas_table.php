<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCurriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculas', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->boolean('state')->default(true);
            $table->unsignedBigInteger('academic_level_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('academic_level_id')->references('id')->on('academic_levels')->onDelete('cascade');
        });

        DB::table('curriculas')->insert([
            'description' => 'Curricula nacional 2016-2021',
            'state' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculas');
    }
}
