<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('warehouse_destination_id');
            $table->decimal('quantity',12,2);
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
        Schema::dropIfExists('inventories_transfers');
    }
}
