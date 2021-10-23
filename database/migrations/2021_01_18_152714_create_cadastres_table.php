<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCadastresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadastre_situations', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });
        Schema::create('cadastres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_level_id')->nullable();
            $table->unsignedBigInteger('academic_section_id')->nullable();
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->unsignedBigInteger('cadastre_situation_id')->nullable();
            $table->string('year')->index();
            $table->date('date_register')->nullable();
            $table->unsignedBigInteger('person_id')->nullable();
            $table->unsignedBigInteger('attorney_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->string('observation')->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('academic_level_id')->references('id')->on('academic_levels')->onDelete('cascade');
            $table->foreign('academic_section_id')->references('id')->on('academic_sections')->onDelete('cascade');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
            $table->foreign('cadastre_situation_id')->references('id')->on('cadastre_situations')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('attorney_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });

        DB::table('cadastre_situations')->insert([
            ['description' => 'Promovido'],
            ['description' => 'Reentrante'],
            ['description' => 'Ingresante'],
            ['description' => 'Permanece en el grado']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cadastres');
        Schema::dropIfExists('cadastre_situations');
    }
}
