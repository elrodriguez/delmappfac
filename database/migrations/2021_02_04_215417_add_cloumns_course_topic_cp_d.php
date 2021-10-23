<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCloumnsCourseTopicCpD extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_topics', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('person_id')->nullable();
            $table->unsignedBigInteger('teacher_course_id')->nullable();
            $table->foreign('user_id','course_topics_user_id_fk')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('person_id','course_topics_person_id_fk')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('teacher_course_id','course_topics_teacher_course_id_fk')->references('id')->on('teacher_courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_topics', function (Blueprint $table) {
            $table->dropForeign('course_topics_teacher_course_id_fk');
            $table->dropForeign('course_topics_person_id_fk');
            $table->dropForeign('course_topics_user_id_fk');
            $table->dropColumn('teacher_course_id');
            $table->dropColumn('person_id');
            $table->dropColumn('user_id');
        });
    }
}
