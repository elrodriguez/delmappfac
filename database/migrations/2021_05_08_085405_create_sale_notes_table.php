<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->uuid('external_id');
            $table->unsignedBigInteger('establishment_id');
            $table->json('establishment');
            $table->char('soap_type_id',2);
            $table->char('state_type_id',2);
            $table->char('prefix',2);
            $table->string('series', 10)->index();
            $table->integer('number')->index();
            $table->date('date_of_issue')->index();
            $table->time('time_of_issue');
            $table->unsignedBigInteger('customer_id');
            $table->json('customer');
            $table->string('currency_type_id');
            $table->char('payment_method_type_id',2)->nullable();
            $table->decimal('exchange_rate_sale')->nullable();
            $table->boolean('apply_concurrency')->default(false);
            $table->boolean('enabled_concurrency')->default(false);
            $table->date('automatic_date_of_issue')->nullable();
            $table->decimal('quantity_period')->nullable();
            $table->string('type_period')->nullable();
            $table->decimal('total_prepayment', 12, 2)->default(0);
            $table->decimal('total_charge', 12, 2)->default(0);
            $table->decimal('total_discount', 12, 2)->default(0);
            $table->decimal('total_exportation', 12, 2)->default(0);
            $table->decimal('total_free', 12, 2)->default(0);
            $table->decimal('total_taxed', 12, 2)->default(0);
            $table->decimal('total_unaffected', 12, 2)->default(0);
            $table->decimal('total_exonerated', 12, 2)->default(0);
            $table->decimal('total_igv', 12, 2)->default(0);
            $table->decimal('total_base_isc', 12, 2)->default(0);
            $table->decimal('total_isc', 12, 2)->default(0);
            $table->decimal('total_base_other_taxes', 12, 2)->default(0);
            $table->decimal('total_other_taxes', 12, 2)->default(0);
            $table->decimal('total_taxes', 12, 2)->default(0);
            $table->decimal('total_value', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->json('charges')->nullable();
            $table->json('discounts')->nullable();
            $table->json('prepayments')->nullable();
            $table->json('guides')->nullable();
            $table->json('related')->nullable();
            $table->json('perception')->nullable();
            $table->json('detraction')->nullable();
            $table->json('legends')->nullable();
            $table->string('filename')->nullable();
            //quotation_id,
            $table->unsignedBigInteger('order_note_id')->nullable();
            $table->boolean('total_canceled')->default(false);
            $table->boolean('changed')->default(false);
            $table->boolean('paid')->default(false);
            $table->string('license_plate')->nullable();
            $table->string('plate_number')->nullable();
            $table->string('reference_data',500)->nullable();
            $table->string('observation',500)->nullable();
            $table->string('purchase_order')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->foreign('customer_id')->references('id')->on('people');
            $table->foreign('soap_type_id')->references('id')->on('soap_types');
            $table->foreign('state_type_id')->references('id')->on('state_types');
            $table->foreign('payment_method_type_id')->references('id')->on('cat_payment_method_types');
            $table->foreign('currency_type_id')->references('id')->on('currency_types');
            $table->foreign('order_note_id')->references('id')->on('sale_notes');
            $table->foreign('document_id')->references('id')->on('documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_notes');
    }
}
