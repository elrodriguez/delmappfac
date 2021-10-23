<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('cadastre_id');
            $table->unsignedBigInteger('year_id')->nullable();
            $table->unsignedBigInteger('secction_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->string('academic_season_id')->nullable();
            $table->string('qualification_id');
            $table->unsignedBigInteger('course_topic_id');
            $table->unsignedBigInteger('teacher_course_id')->nullable();
            $table->string('description')->nullable();
            $table->char('group_ca',2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_qualifications');
    }
}
