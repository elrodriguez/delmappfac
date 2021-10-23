<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupServiceAreaGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sup_service_area_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sup_service_area_id');
            $table->string('description');
            $table->boolean('state')->default(true);
            $table->timestamps();
            $table->foreign('sup_service_area_id')->references('id')->on('sup_service_areas');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sup_service_area_groups');
    }
}
