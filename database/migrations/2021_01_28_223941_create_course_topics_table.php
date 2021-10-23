<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_topics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->boolean('state')->default(true);
            $table->integer('number')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('course_id')->references('id')->on('courses')->delete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_topics');
    }
}
