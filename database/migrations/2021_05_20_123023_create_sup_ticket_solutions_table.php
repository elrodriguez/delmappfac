<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupTicketSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sup_ticket_solutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sup_category_id');
            $table->unsignedBigInteger('sup_ticket_id');
            $table->unsignedBigInteger('user_id');
            $table->text('solution_description');
            $table->integer('points')->default(0);
            $table->unsignedBigInteger('user_id_like')->nullable();
            $table->timestamps();
            $table->foreign('sup_category_id')->references('id')->on('sup_categories');
            $table->foreign('sup_ticket_id')->references('id')->on('sup_tickets');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_id_like')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sup_ticket_solutions');
    }
}
