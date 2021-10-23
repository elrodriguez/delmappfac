<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->date('date_of_payment');
            $table->string('payment_method_type_id')->nullable();
            $table->boolean('has_card')->default(false);
            $table->string('card_brand_id')->nullable();
            $table->string('reference')->nullable();
            $table->decimal('change',12,2)->nullable();
            $table->decimal('payment',12,2)->nullable();
            $table->timestamps();
            $table->foreign('document_id','document_payments_document_id_fky')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('payment_method_type_id','document_payments_ibfk_1')->references('id')->on('cat_payment_method_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_payments');
    }
}
