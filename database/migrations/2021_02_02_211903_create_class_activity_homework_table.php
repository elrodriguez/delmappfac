<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassActivityHomeworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_activity_homework', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('class_activity_id');
            $table->unsignedBigInteger('class_activity_homework_id')->nullable();
            $table->string('description',500);
            $table->integer('points')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('class_activity_id')->references('id')->on('class_activities')->onDelete('cascade');
            $table->foreign('class_activity_homework_id')->references('id')->on('class_activity_homework')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_activity_homework');
    }
}
