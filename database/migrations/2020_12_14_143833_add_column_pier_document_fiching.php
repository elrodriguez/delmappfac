<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPierDocumentFiching extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_fishings', function (Blueprint $table) {
            $table->unsignedBigInteger('pier_id')->nullable();
            $table->foreign('pier_id','document_fishings_pier_id_foreign')->references('id')->on('piers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_fishings', function (Blueprint $table) {
            $table->dropForeign('document_fishings_pier_id_foreign');
            $table->dropColumn('pier_id');
        });
    }
}
