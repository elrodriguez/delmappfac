<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateExpenseReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });
        DB::table('expense_reasons')->insert([
            ['id' => '1', 'description' => 'Varios'],
            ['id' => '2', 'description' => 'Representación de la organización'],
            ['id' => '3', 'description' => 'Trabajo de campo'],
        ]);

        Schema::table('expenses',function (Blueprint $table){
            $table->boolean('state')->default(true);
            $table->unsignedBigInteger('expense_reason_id')->nullable();
            $table->foreign('expense_reason_id','expenses_expense_reason_id_fk')->references('id')->on('expense_reasons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses',function (Blueprint $table){
            $table->dropForeign('expenses_expense_reason_id_fk');
            $table->dropColumn('expense_reason_id');
            $table->dropColumn('state');
        });
        Schema::dropIfExists('expense_reasons');
    }
}
