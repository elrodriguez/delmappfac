<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_level_id')->nullable();
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->unsignedBigInteger('academic_section_id')->nullable();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('course_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('academic_level_id','te_courses_aca_level_id_foreign')->references('id')->on('academic_levels')->onDelete('cascade');
            $table->foreign('academic_year_id','te_courses_aca_year_id_foreign')->references('id')->on('academic_years')->onDelete('cascade');
            $table->foreign('academic_section_id','te_courses_aca_section_id_foreign')->references('id')->on('academic_sections')->onDelete('cascade');
            $table->foreign('teacher_id','teacher_courses_ibfk_1')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('course_id','te_courses_course_id_foreign')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_courses');
    }
}
