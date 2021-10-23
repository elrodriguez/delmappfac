<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnItensPlastic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('item_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('state')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('item_category_id')->nullable();
            $table->foreign('item_category_id','item_categories_item_category_id_fk')->references('id')->on('item_categories');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->string('digemid',50)->nullable();
            $table->boolean('apply_store')->default(false);
            $table->boolean('status')->default(true);
            $table->boolean('active')->default(true);
            $table->decimal('percentage_perception',12,2)->nullable();
            $table->boolean('has_perception')->default(false);
            $table->decimal('percentage_of_profit',12,2)->nullable();
            $table->boolean('series_enabled')->default(false);
            $table->boolean('lots_enabled')->default(false);
            $table->string('image')->nullable();
            $table->string('image_medium')->nullable();
            $table->string('image_small')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->boolean('is_set')->default(false);
            $table->decimal('sale_unit_price_set',12,2)->nullable();
            $table->boolean('calculate_quantity')->default(false);
            $table->string('commission_type')->nullable();
            $table->string('line')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->date('date_of_due')->nullable();
            $table->string('name')->nullable();
            $table->string('second_name')->nullable();
            $table->boolean('has_igv')->default(true);
            $table->boolean('has_plastic_bag_taxes')->default(false);
            $table->string('barcode')->nullable();
            $table->string('lot_code')->nullable();
            $table->decimal('commission_amount',12,2)->nullable();
            $table->foreign('account_id','items_account_id_fk')->references('id')->on('accounts');
            $table->foreign('category_id','items_category_id_fk')->references('id')->on('item_categories');
            $table->foreign('brand_id','items_brand_id_fk')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_brand_id_fk');
            $table->dropForeign('items_category_id_fk');
            $table->dropForeign('items_account_id_fk');
            $table->dropColumn('commission_amount');
            $table->dropColumn('lot_code');
            $table->dropColumn('barcode');
            $table->dropColumn('has_plastic_bag_taxes');
            $table->dropColumn('has_igv');
            $table->dropColumn('second_name');
            $table->dropColumn('name');
            $table->dropColumn('date_of_due');
            $table->dropColumn('account_id');
            $table->dropColumn('line');
            $table->dropColumn('commission_type');
            $table->dropColumn('calculate_quantity');
            $table->dropColumn('sale_unit_price_set');
            $table->dropColumn('is_set');
            $table->dropColumn('category_id');
            $table->dropColumn('image_small');
            $table->dropColumn('image_medium');
            $table->dropColumn('image');
            $table->dropColumn('lots_enabled');
            $table->dropColumn('series_enabled');
            $table->dropColumn('percentage_of_profit');
            $table->dropColumn('has_perception');
            $table->dropColumn('percentage_perception');
            $table->dropColumn('active');
            $table->dropColumn('status');
            $table->dropColumn('apply_store');
            $table->dropColumn('digemid');
        });

        Schema::table('item_categories', function (Blueprint $table) {
            Schema::dropIfExists('item_categories');
        });

        Schema::table('accounts', function (Blueprint $table) {
            Schema::dropIfExists('accounts');
        });
    }
}
