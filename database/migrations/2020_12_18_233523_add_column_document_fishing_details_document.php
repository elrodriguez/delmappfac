<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDocumentFishingDetailsDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_fishing_details', function (Blueprint $table) {
            $table->unsignedBigInteger('document_fishing_id');
            $table->foreign('document_fishing_id','documet_fishs_de_docme_fish_id_foreign')->references('id')->on('document_fishings')->onDelete('cascade');
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
            $table->dropForeign('documet_fishs_de_docme_fish_id_foreign');
            $table->dropColumn('document_fishing_id');
        });
    }
}
