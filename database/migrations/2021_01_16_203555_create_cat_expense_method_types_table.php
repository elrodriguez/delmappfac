<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCatExpenseMethodTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_expense_method_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->boolean('has_card')->default(true);
            $table->timestamps();
        });

        DB::table('cat_expense_method_types')->insert([
            ['description' => 'Caja chica','has_card' => 0],
            ['description' => 'Tarjeta de débito','has_card' => 1]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_expense_method_types');
    }
}
