<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sho_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('color')->nullable();
            $table->decimal('price',12,2)->default(0);
            $table->decimal('stock',12,2)->default(0);
            $table->boolean('state')->default(true);
            $table->boolean('new_product')->default(false);
            $table->text('seo_url');
            $table->timestamps();
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
        Schema::dropIfExists('sho_items');
    }
}
