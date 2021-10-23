<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_payments', function (Blueprint $table) {
            $table->id();
            $table->char('soap_type_id',2);
            $table->bigInteger('destination_id');
            $table->string('destination_type');
            $table->bigInteger('payment_id');
            $table->string('payment_type');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('soap_type_id')->references('id')->on('soap_types');
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
        Schema::dropIfExists('global_payments');
    }
}
