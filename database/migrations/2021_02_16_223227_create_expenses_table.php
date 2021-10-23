<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('expense_type_id');
            $table->unsignedBigInteger('establishment_id');
            $table->unsignedBigInteger('person_id');
            $table->string('currency_type_id');
            $table->uuid('external_id');
            $table->integer('number');
            $table->date('date_of_issue');
            $table->time('time_of_issue');
            $table->json('supplier');
            $table->decimal('exchange_rate_sale', 12, 2);
            $table->decimal('total', 12, 2);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('expense_type_id')->references('id')->on('expense_types')->onDelete('cascade');
            $table->foreign('currency_type_id')->references('id')->on('currency_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
