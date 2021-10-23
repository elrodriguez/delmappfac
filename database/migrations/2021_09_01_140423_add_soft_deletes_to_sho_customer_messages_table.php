<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToShoCustomerMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sho_customer_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_message_id')->nullable();
            $table->string('message_id')->nullable();
            $table->boolean('send')->default(false);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sho_customer_messages', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('send');
            $table->dropColumn('message_id');
            $table->dropColumn('customer_message_id');
        });
    }
}
