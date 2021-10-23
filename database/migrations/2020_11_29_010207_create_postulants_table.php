<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostulantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulants', function (Blueprint $table) {
            $table->id();
            $table->string('inscription_code')->nullable();
            $table->string('modular_code')->nullable();
            $table->string('student_code')->nullable();
            $table->char('country_id', 2);
            $table->char('department_id', 2)->nullable();
            $table->char('province_id', 4)->nullable();
            $table->char('district_id', 6)->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('marital_state')->nullable();
            $table->boolean('worke')->default(false);
            $table->string('position')->nullable();
            $table->string('id_training_level')->nullable();
            $table->unsignedBigInteger('id_career')->nullable();
            $table->string('id_management_type')->nullable();
            $table->unsignedBigInteger('id_resolution')->nullable();
            $table->string('id_resolution_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('id_training_level')->references('id')->on('training_levels');
            $table->foreign('id_career')->references('id')->on('careers');
            $table->foreign('id_management_type')->references('id')->on('management_types');
            $table->foreign('id_resolution')->references('id')->on('resolutions');
            $table->foreign('id_resolution_type')->references('id')->on('resolution_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postulants');
    }
}
