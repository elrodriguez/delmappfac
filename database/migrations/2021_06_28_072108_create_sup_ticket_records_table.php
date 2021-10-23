<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupTicketRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sup_ticket_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sup_ticket_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('from_area_id');
            $table->unsignedBigInteger('from_group_id')->nullable();
            $table->unsignedBigInteger('to_area_id')->nullable();
            $table->unsignedBigInteger('to_group_id')->nullable();
            $table->text('description')->nullable();
            $table->string('state')->nullable();
            $table->unsignedBigInteger('establishment_id')->nullable();
            $table->timestamps();
            $table->foreign('sup_ticket_id')->references('id')->on('sup_tickets');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('from_area_id')->references('id')->on('sup_service_areas');
            $table->foreign('from_group_id')->references('id')->on('sup_service_area_groups');
            $table->foreign('to_area_id')->references('id')->on('sup_service_areas');
            $table->foreign('to_group_id')->references('id')->on('sup_service_area_groups');
            $table->foreign('establishment_id')->references('id')->on('establishments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sup_ticket_records');
    }
}
