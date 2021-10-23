<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cash_id');
            $table->unsignedBigInteger('document_id')->nullable();
            $table->unsignedBigInteger('sale_note_id')->nullable();
            $table->unsignedBigInteger('expense_payment_id')->nullable();
            $table->timestamps();
            $table->foreign('cash_id')->references('id')->on('cashes');
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('sale_note_id')->references('id')->on('sale_notes');
            $table->foreign('expense_payment_id')->references('id')->on('expense_payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_documents');
    }
}
