<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_classes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->char('time_start',8)->nullable();
            $table->char('time_end',8)->nullable();
            $table->boolean('state')->default(true);
            $table->boolean('live')->default(false);
            $table->integer('number')->default(1);
            $table->unsignedBigInteger('course_topic_id')->nullable();
            $table->timestamps();
            $table->foreign('course_topic_id')->references('id')->on('course_topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topic_classes');
    }
}
