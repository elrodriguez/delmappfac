<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAssistanceStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_assistance_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('academic_level_id')->nullable();
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->unsignedBigInteger('academic_section_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('curricula_id')->nullable();
            $table->string('academic_season_id')->nullable();
            $table->integer('assistance_year');
            $table->integer('assistance_month');
            $table->integer('assistance_day');
            $table->date('assistance_date');
            $table->boolean('attended')->default(false);
            $table->boolean('justified')->nullable(false);
            $table->string('observation',300)->nullable();
            $table->timestamps();
            $table->foreign('person_id')->references('id')->on('people');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('curricula_id')->references('id')->on('curriculas');
            $table->foreign('academic_season_id')->references('id')->on('academic_seasons');
            $table->foreign('academic_level_id')->references('id')->on('academic_levels');
            $table->foreign('academic_section_id')->references('id')->on('academic_sections');
            $table->foreign('academic_year_id')->references('id')->on('academic_years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_assistance_students');
    }
}
