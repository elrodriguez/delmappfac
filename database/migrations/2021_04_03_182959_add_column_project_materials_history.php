<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProjectMaterialsHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_materials', function (Blueprint $table) {
            $table->decimal('obsolete_quantity',12,2)->default(0);
            $table->decimal('lost_quantity',12,2)->default(0);
            $table->decimal('pending_quantity',12,2)->default(0);
            $table->decimal('leftovers_quantity',12,2)->default(0);
            $table->text('observations')->nullable();
        });
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('inventory_transaction_id')->nullable();
            $table->string('lot_code')->nullable();
            $table->unsignedBigInteger('inventories_transfer_id')->nullable();
            $table->foreign('inventory_transaction_id','inventories_inventory_transaction_id_fk')->references('id')->on('inventory_transactions');
            $table->foreign('inventories_transfer_id','inventories_inventories_transfer_id_fk')->references('id')->on('inventories_transfers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_materials', function (Blueprint $table) {
            $table->dropColumn('observations');
            $table->dropColumn('leftovers_quantity');
            $table->dropColumn('obsolete_quantity');
            $table->dropColumn('lost_quantity');
            $table->dropColumn('pending_quantity');
        });
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropForeign('inventories_inventories_transfer_id_fk');
            $table->dropForeign('inventories_inventory_transaction_id_fk');
            $table->dropColumn('inventories_transfer_id');
            $table->dropColumn('lot_code');
            $table->dropColumn('inventory_transaction_id');
        });
    }
}
