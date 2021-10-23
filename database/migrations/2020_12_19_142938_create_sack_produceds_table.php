<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSackProducedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sack_produceds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_fishing_id')->nullable();
            $table->unsignedBigInteger('fishing_id');
            $table->unsignedBigInteger('freezer_id');
            $table->unsignedBigInteger('customer_id');
            $table->json('customer');
            $table->decimal('quantity',12,2)->default(0);
            $table->timestamps();
            $table->foreign('document_fishing_id','sack_produceds_document_fishing_id_foreign')->references('id')->on('document_fishings')->onDelete('cascade');
            $table->foreign('fishing_id','sack_producedsfishing_id_foreign')->references('id')->on('fishings')->onDelete('cascade');
            $table->foreign('freezer_id','sack_produceds_freezer_id_foreign')->references('id')->on('freezers')->onDelete('cascade');
            $table->foreign('customer_id','sack_produceds_customer_id_foreign')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sack_produceds');
    }
}
