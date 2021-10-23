<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('short')->nullable();
            $table->string('description');
            $table->timestamps();
        });
        DB::table('document_types')->insert([
            ['id' => '01', 'active' => true,  'short' => 'FT', 'description' => 'FACTURA ELECTRÓNICA'],
            ['id' => '03', 'active' => true,  'short' => 'BV', 'description' => 'BOLETA DE VENTA ELECTRÓNICA'],
            ['id' => '07', 'active' => true,  'short' => 'NC', 'description' => 'NOTA DE CRÉDITO'],
            ['id' => '08', 'active' => true,  'short' => 'ND', 'description' => 'NOTA DE DÉBITO'],
            ['id' => '09', 'active' => true,  'short' => null, 'description' => 'GUIA DE REMISIÓN REMITENTE'],
            ['id' => '20', 'active' => true,  'short' => null, 'description' => 'COMPROBANTE DE RETENCIÓN ELECTRÓNICA'],
            ['id' => '31', 'active' => true,  'short' => null, 'description' => 'Guía de remisión transportista'],
            ['id' => '40', 'active' => true,  'short' => null, 'description' => 'COMPROBANTE DE PERCEPCIÓN ELECTRÓNICA'],
            ['id' => '71', 'active' => false, 'short' => null, 'description' => 'Guia de remisión remitente complementaria'],
            ['id' => '72', 'active' => false, 'short' => null, 'description' => 'Guia de remisión transportista complementaria'],
            ['id' => 'GU75', 'active' => true, 'short' => null, 'description' => 'GUÍA'],
            ['id' => 'NE76', 'active' => true, 'short' => null, 'description' => 'NOTA DE ENTRADA'],
            ['id' => '80', 'active' => true, 'short' => null, 'description' => 'NOTA DE VENTA']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_types');
    }
}
