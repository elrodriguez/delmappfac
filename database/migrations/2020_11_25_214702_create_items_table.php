<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->char('item_type_id', 2);
            $table->string('internal_id', 30)->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_code_gs1')->nullable();
            $table->string('unit_type_id');
            $table->string('currency_type_id');
            $table->decimal('sale_unit_price', 12, 2);
            $table->decimal('purchase_unit_price', 12, 2)->default(0);
            $table->boolean('has_isc')->default(false);
            $table->string('system_isc_type_id')->nullable();
            $table->decimal('percentage_isc', 12, 2)->default(0);
            $table->decimal('suggested_price', 12, 2)->default(0);
            $table->string('sale_affectation_igv_type_id');
            $table->string('purchase_affectation_igv_type_id');
            $table->decimal('stock', 12, 2)->default(0);
            $table->decimal('stock_min', 12, 2)->default(0);
            $table->json('attributes')->nullable();
            $table->timestamps();
            $table->foreign('item_type_id')->references('id')->on('item_types');
            $table->foreign('unit_type_id')->references('id')->on('unit_types');
            $table->foreign('currency_type_id')->references('id')->on('currency_types');
            $table->foreign('system_isc_type_id')->references('id')->on('system_isc_types');
            $table->foreign('sale_affectation_igv_type_id')->references('id')->on('affectation_igv_types');
            $table->foreign('purchase_affectation_igv_type_id')->references('id')->on('affectation_igv_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
