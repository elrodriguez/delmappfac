<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProEmpExpenseItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expense_items', function (Blueprint $table) {
            $table->unsignedBigInteger('proj_emp_id')->nullable();
            $table->foreign('proj_emp_id','expense_items_proj_emp_id_fk')->references('id')->on('project_employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expense_items', function (Blueprint $table) {
            $table->dropForeign('expense_items_proj_emp_id_fk');
            $table->dropColumn('proj_emp_id');
        });
    }
}
