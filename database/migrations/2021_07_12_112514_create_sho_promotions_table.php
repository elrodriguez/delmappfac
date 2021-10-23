<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sho_promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title',40);
            $table->string('description',50);
            $table->string('image')->nullable();
            $table->string('url_action')->nullable();
            $table->decimal('total_price',12,2)->default(0);
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sho_promotions');
    }
}
