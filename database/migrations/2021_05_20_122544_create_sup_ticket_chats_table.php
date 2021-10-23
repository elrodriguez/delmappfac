<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupTicketChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sup_ticket_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sup_ticket_id');
            $table->unsignedBigInteger('user_id');
            $table->json('user');
            $table->text('message');
            $table->boolean('html')->default(false);
            $table->timestamps();
            $table->foreign('sup_ticket_id')->references('id')->on('sup_tickets');
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
        Schema::dropIfExists('sup_ticket_chats');
    }
}
