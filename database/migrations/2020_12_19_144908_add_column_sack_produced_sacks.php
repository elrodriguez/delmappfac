<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSackProducedSacks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sack_produceds', function (Blueprint $table) {
            $table->unsignedBigInteger('sack_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('sack_id','sack_produceds_sack_id_foreign')->references('id')->on('sacks')->onDelete('cascade');
            $table->foreign('user_id','sack_produceds_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sack_produceds', function (Blueprint $table) {
            $table->dropForeign('sack_produceds_user_id_foreign');
            $table->dropForeign('sack_produceds_sack_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('sack_id');
        });
    }
}
