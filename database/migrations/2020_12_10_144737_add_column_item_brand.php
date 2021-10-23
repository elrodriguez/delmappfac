<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnItemBrand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_brands', function (Blueprint $table) {
            $table->decimal('pallet_multiplo', 12, 2)->default(0);
            $table->decimal('fila_multiplo', 12, 2)->default(0);
            $table->decimal('canastilla_multiplo', 12, 2)->default(0);
            $table->decimal('caja_multiplo', 12, 2)->default(0);
            $table->decimal('unidad_multiplo', 12, 2)->default(0);
            $table->decimal('cubeta_multiplo', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_brands', function (Blueprint $table) {
            $table->dropColumn('cubeta_multiplo');
            $table->dropColumn('unidad_multiplo');
            $table->dropColumn('caja_multiplo');
            $table->dropColumn('canastilla_multiplo');
            $table->dropColumn('fila_multiplo');
            $table->dropColumn('pallet_multiplo');
        });
    }
}
