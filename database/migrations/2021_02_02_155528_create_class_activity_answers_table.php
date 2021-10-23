<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassActivityAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_activity_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('class_activity_id');
            $table->unsignedBigInteger('class_activity_answer_id')->nullable();
            $table->longText('answer_text');
            $table->integer('points')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('class_activity_id')->references('id')->on('class_activities')->onDelete('cascade');
            $table->foreign('class_activity_answer_id')->references('id')->on('class_activity_answers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_activity_answers');
    }
}
