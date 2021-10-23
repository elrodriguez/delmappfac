<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sacks', function (Blueprint $table) {
            $table->id();
            $table->decimal('weight',12,2)->default(20);
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('fishing_id');
            $table->decimal('stock',12,2)->default(0);
            $table->timestamps();
            $table->foreign('customer_id','sacks_customer_id_foreign')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('fishing_id','sacks_fishing_id_foreign')->references('id')->on('fishings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sacks');
    }
}
