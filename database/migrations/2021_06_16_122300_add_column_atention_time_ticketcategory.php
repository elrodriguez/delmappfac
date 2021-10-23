<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAtentionTimeTicketcategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sup_ticket_users', function (Blueprint $table) {
            $table->integer('stars')->default(0);
        });
        Schema::table('sup_categories', function (Blueprint $table) {
            $table->integer('minutes')->default(30);
            $table->integer('hours')->default(0);
            $table->integer('days')->default(0);
        });
        Schema::table('sup_tickets', function (Blueprint $table) {
            $table->integer('minutes')->default(30);
            $table->integer('hours')->default(0);
            $table->integer('days')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sup_ticket_users', function (Blueprint $table) {
            $table->dropColumn('stars');
        });
        Schema::table('sup_categories', function (Blueprint $table) {
            $table->dropColumn('days');
            $table->dropColumn('hours');
            $table->dropColumn('minutes');
        });
        Schema::table('sup_tickets', function (Blueprint $table) {
            $table->dropColumn('days');
            $table->dropColumn('hours');
            $table->dropColumn('minutes');
        });
    }
}
