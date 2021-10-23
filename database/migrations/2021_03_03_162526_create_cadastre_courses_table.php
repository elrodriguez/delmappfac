<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadastreCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadastre_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cadastre_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->timestamps();
            $table->boolean('state')->default(true);
            $table->foreign('cadastre_id')->references('id')->on('cadastres')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cadastre_courses');
    }
}
