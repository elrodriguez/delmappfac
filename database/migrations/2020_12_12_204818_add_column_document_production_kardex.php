<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDocumentProductionKardex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kardex', function (Blueprint $table) {
            $table->unsignedBigInteger('document_production_id')->nullable();
            $table->foreign('document_production_id','kardex_document_production_id_foreign')->references('id')->on('document_productions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kardex', function (Blueprint $table) {
            $table->dropForeign('kardex_document_production_id_foreign');
            $table->dropColumn('document_production_id');
        });
    }
}
