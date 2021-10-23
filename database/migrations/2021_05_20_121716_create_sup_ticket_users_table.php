<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupTicketUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sup_ticket_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sup_ticket_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['applicant', 'technical','attached','checkin']);
            $table->boolean('incharge')->default(true);
            $table->unsignedBigInteger('sup_service_area_id')->nullable();
            $table->timestamps();
            $table->foreign('sup_ticket_id')->references('id')->on('sup_tickets');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('sup_ticket_users');
    }
}
