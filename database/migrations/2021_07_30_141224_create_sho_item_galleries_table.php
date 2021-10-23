<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoItemGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sho_item_galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_item_id');
            $table->unsignedBigInteger('item_id');
            $table->string('url')->nullable();
            $table->string('name',500)->nullable();
            $table->boolean('state')->default(true);
            $table->boolean('principal')->default(true);
            $table->timestamps();
            $table->foreign('shop_item_id')->references('id')->on('sho_items')->ondelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sho_item_galleries');
    }
}
