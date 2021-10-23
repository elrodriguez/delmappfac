<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTestAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_test_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_test_id');
            $table->unsignedBigInteger('class_activitie_id');
            $table->unsignedBigInteger('class_activity_test_question_id');
            $table->unsignedBigInteger('class_activity_test_answer_id')->nullable();
            $table->decimal('point',12,2)->default(0);
            $table->timestamps();
            $table->foreign('student_test_id','student_test_answers_sti_fk')->references('id')->on('student_tests')->onDelete('cascade');
            $table->foreign('class_activitie_id','student_test_answers_cai_fk')->references('id')->on('class_activities')->onDelete('cascade');
            $table->foreign('class_activity_test_question_id','student_test_answers_catqi_fk')->references('id')->on('class_activity_test_questions')->onDelete('cascade');
            $table->foreign('class_activity_test_answer_id','student_test_answers_catai_fk')->references('id')->on('class_activity_test_answers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_test_answers');
    }
}
