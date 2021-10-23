<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassActivityTestAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_activity_test_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_activity_test_question_id');
            $table->longText('answer_text')->nullable();
            $table->boolean('correct')->default(false);
            $table->timestamps();
            $table->foreign('class_activity_test_question_id','class_activity_test_answers_question_fk')->references('id')->on('class_activity_test_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_activity_test_answers');
    }
}
