<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTransferReasonTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_reason_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('description');
            $table->timestamps();
        });
        DB::table('transfer_reason_types')->insert([
            ['id' => '01', 'active' => true, 'description' => 'Venta'],
            ['id' => '02', 'active' => true, 'description' => 'Compra'],
            ['id' => '04', 'active' => true, 'description' => 'Traslado entre establecimientos de la misma empresa'],
            ['id' => '08', 'active' => true, 'description' => 'Importación'],
            ['id' => '09', 'active' => true, 'description' => 'Exportación'],
            ['id' => '13', 'active' => true, 'description' => 'Otros'],
            ['id' => '14', 'active' => true, 'description' => 'Venta sujeta a confirmación del comprador'],
            ['id' => '18', 'active' => true, 'description' => 'Traslado emisor itinerante CP'],
            ['id' => '19', 'active' => true, 'description' => 'Traslado a zona primaria'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer_reason_types');
    }
}
