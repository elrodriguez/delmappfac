<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnBankAccountsInitial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->string('cci')->nullable();
            $table->boolean('state')->default(true);
            $table->decimal('initial_balance',12,2)->default(0);
        });

        Schema::table('expense_method_types', function (Blueprint $table) {
            $table->char('card_brand_id',2)->nullable();
            $table->foreign('card_brand_id','expense_method_types_card_brand_id_fk')->references('id')->on('card_brands');
        });

        DB::table('expense_method_types')->where('has_card',1)->update(['card_brand_id'=>'01']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn('initial_balance');
            $table->dropColumn('state');
            $table->dropColumn('cci');
        });

        Schema::table('expense_method_types', function (Blueprint $table) {
            $table->dropForeign('expense_method_types_card_brand_id_fk');
            $table->dropColumn('card_brand_id');
        });
    }
}
