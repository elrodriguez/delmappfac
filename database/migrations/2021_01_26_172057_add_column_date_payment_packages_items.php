<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDatePaymentPackagesItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_item_details', function (Blueprint $table) {
            $table->date('date_payment')->nullable();
            $table->boolean('to_block')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_item_details', function (Blueprint $table) {
            $table->dropColumn('to_block');
            $table->dropColumn('date_payment');
        });
    }
}
