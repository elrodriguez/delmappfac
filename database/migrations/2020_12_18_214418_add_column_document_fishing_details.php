<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDocumentFishingDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_fishing_details', function (Blueprint $table) {
            $table->string('unit_type_id')->nullable();
            $table->json('item')->nullable();
            $table->unsignedBigInteger('fishing_id')->nullable();
            $table->foreign('fishing_id','document_fishings_de_fishing_id_foreign')->references('id')->on('fishings')->onDelete('cascade');
            $table->foreign('unit_type_id','docume_fishin_de_unit_type_id_foreign')->references('id')->on('unit_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_fishing_details', function (Blueprint $table) {
            $table->dropForeign('docume_fishin_de_unit_type_id_foreign');
            $table->dropForeign('document_fishings_de_fishing_id_foreign');
            $table->dropColumn('fishing_id');
            $table->dropColumn('item');
            $table->dropColumn('unit_type_id');
        });
    }
}
