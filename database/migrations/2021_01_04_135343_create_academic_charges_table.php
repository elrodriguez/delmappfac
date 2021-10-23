<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_level_id')->nullable();
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->unsignedBigInteger('academic_section_id')->nullable();
            $table->unsignedBigInteger('course_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('academic_level_id','academic_charges_level_id_foreign')->references('id')->on('academic_levels')->onDelete('cascade');
            $table->foreign('academic_year_id','academic_charges_year_id_foreign')->references('id')->on('academic_years')->onDelete('cascade');
            $table->foreign('academic_section_id','academic_charges_section_id_foreign')->references('id')->on('academic_sections')->onDelete('cascade');
            $table->foreign('course_id','academic_charges_course_id_foreign')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_charges');
    }
}
