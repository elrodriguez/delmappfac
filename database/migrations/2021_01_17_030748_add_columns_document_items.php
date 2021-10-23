<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsDocumentItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_items', function (Blueprint $table) {
            $table->decimal('sub_total_item',12,2)->default(0);
            $table->decimal('total_free',12,2)->default(0);
            $table->decimal('percentage_discounts',12,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_items', function (Blueprint $table) {
            $table->dropColumn('percentage_discounts');
            $table->dropColumn('total_free');
            $table->dropColumn('sub_total_item');
        });
    }
}
