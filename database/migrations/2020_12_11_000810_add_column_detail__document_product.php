<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDetailDocumentProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_productions', function (Blueprint $table) {
            $table->decimal('pallets', 12, 2)->default(0);
            $table->decimal('filas', 12, 2)->default(0);
            $table->decimal('canastillas', 12, 2)->default(0);
            $table->decimal('cajas', 12, 2)->default(0);
            $table->decimal('unidades', 12, 2)->default(0);
            $table->decimal('cubetas', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_productions', function (Blueprint $table) {
            $table->dropColumn('cubetas');
            $table->dropColumn('unidades');
            $table->dropColumn('cajas');
            $table->dropColumn('canastillas');
            $table->dropColumn('filas');
            $table->dropColumn('pallets');
        });
    }
}
