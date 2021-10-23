<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_activitie_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('score',12,2)->default(0);
            $table->enum('state',['aprobado', 'desaprobado','ausente'])->nullable();
            $table->time('duration')->nullable();
            $table->timestamps();
            $table->foreign('class_activitie_id')->references('id')->on('class_activities')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_tests');
    }
}
