<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_productions', function (Blueprint $table) {
            $table->id();
            $table->string('code_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->decimal('quantity', 12, 2)->default(0);
            $table->date('date_of_issue');
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_productions');
    }
}
