<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSummaryStatusTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('summary_status_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('description');
            $table->timestamps();
        });
        DB::table('summary_status_types')->insert([
            ['id' => '1', 'active' => true, 'description' => 'Adicionar'],
            ['id' => '2', 'active' => true, 'description' => 'Modificar'],
            ['id' => '3', 'active' => true, 'description' => 'Anulado'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('summary_status_types');
    }
}
