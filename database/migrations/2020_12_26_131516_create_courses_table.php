<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_level_id')->nullable();
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->unsignedBigInteger('academic_section_id')->nullable();
            $table->string('description');
            $table->decimal('hours',12,2)->nullable();
            $table->decimal('credits',12,2)->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('academic_level_id','courses_academic_level_id_foreign')->references('id')->on('academic_levels')->onDelete('cascade');
            $table->foreign('academic_year_id','courses_academic_year_id_foreign')->references('id')->on('academic_years')->onDelete('cascade');
            $table->foreign('academic_section_id','courses_academic_section_id_foreign')->references('id')->on('academic_sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
