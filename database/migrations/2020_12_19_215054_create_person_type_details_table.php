<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonTypeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_type_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('person_type_id');
            $table->timestamps();
            $table->foreign('person_id','person_type_details_person_id_foreign')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('person_type_id','person_type_details_person_type_id_foreign')->references('id')->on('person_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_type_details');
    }
}
