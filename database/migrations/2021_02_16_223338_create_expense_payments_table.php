<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_id');
            $table->date('date_of_payment');
            $table->unsignedBigInteger('expense_method_type_id');
            $table->boolean('has_card')->default(false);
            $table->char('card_brand_id', 2)->nullable();
            $table->string('reference')->nullable();
            $table->decimal('payment', 12, 2);
            $table->timestamps();
            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('cascade');
            $table->foreign('card_brand_id')->references('id')->on('card_brands');
            $table->foreign('expense_method_type_id')->references('id')->on('expense_method_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_payments');
    }
}
