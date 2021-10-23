<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnExpensePaymentsBa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expense_payments', function (Blueprint $table) {
            $table->unsignedInteger('bank_account_id')->nullable();
            $table->foreign('bank_account_id','expense_payments_bank_account_id_fk')->references('id')->on('bank_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expense_payments', function (Blueprint $table) {
            $table->dropForeign('expense_payments_bank_account_id_fk');
            $table->dropColumn('bank_account_id');
        });
    }
}
