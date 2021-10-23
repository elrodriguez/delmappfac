<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_item_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->integer('order_number')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('package_id','package_item_details_package_id_foreign')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('item_id','package_item_details_item_id_foreign')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('discount_id','package_item_details_discount_id_foreign')->references('id')->on('discounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_item_details');
    }
}
