<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupServiceAreaUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sup_service_area_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sup_service_area_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('sup_service_area_id')->references('id')->on('sup_service_areas');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sup_service_area_users');
    }
}
