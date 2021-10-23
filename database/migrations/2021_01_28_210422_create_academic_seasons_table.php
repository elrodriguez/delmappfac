<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAcademicSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_seasons', function (Blueprint $table) {
            $table->string('id',4)->unique();
            $table->string('description')->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('academic_seasons')->insert([
            'id'=>date('Y'),
            'description'=>date('Y')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_seasons');
    }
}
