<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOccupation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occupations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('career_id')->nullable();
            $table->string('description');
            $table->timestamps();
            $table->foreign('career_id')->references('id')->on('careers')->onDelete('cascade');
        });
        Schema::table('project_employees', function (Blueprint $table) {
            $table->unsignedBigInteger('occupation_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('stage_id')->nullable();
            $table->foreign('occupation_id','project_employees_occupation_id_fk')->references('id')->on('occupations')->onDelete('cascade');
            $table->foreign('project_id','project_employees_project_id_fk')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('stage_id','project_employees_stage_id_fk')->references('id')->on('stages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_employees', function (Blueprint $table) {
            $table->dropForeign('project_employees_stage_id_fk');
            $table->dropForeign('project_employees_project_id_fk');
            $table->dropForeign('project_employees_occupation_id_fk');
            $table->dropColumn('stage_id');
            $table->dropColumn('project_id');
            $table->dropColumn('occupation_id');
        });
        Schema::dropIfExists('occupations');
    }
}
