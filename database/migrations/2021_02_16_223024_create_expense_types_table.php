<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateExpenseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });
        DB::table('expense_types')->insert([
            ['id' => '1', 'description' => 'PLANILLA', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '2', 'description' => 'RECIBO POR HONORARIO', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '3', 'description' => 'SERVICIO PÚBLICO', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '4', 'description' => 'OTROS', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_types');
    }
}
