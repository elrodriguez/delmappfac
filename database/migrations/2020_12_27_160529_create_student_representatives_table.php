<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentRepresentativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_representatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('representative_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('person_student_id');
            $table->boolean('lives')->default(true);
            $table->boolean('live_with_the_student')->default(true);
            $table->string('relationship')->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('representative_id','student_repr_repre_id_foreign')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('student_id','student_repr_student_id_foreign')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('person_student_id','student_repr_per_stu_id_foreign')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_representatives');
    }
}
