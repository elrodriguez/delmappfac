<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOperationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->boolean('exportation');
            $table->string('description');
            $table->timestamps();
        });
        DB::table('operation_types')->insert([
            ['id' => '0101', 'active' => true,  'exportation' => false, 'description' => 'Venta interna'],
            ['id' => '0112', 'active' => false, 'exportation' => false, 'description' => 'Venta Interna - Sustenta Gastos Deducibles Persona Natural'],
            ['id' => '0113', 'active' => false, 'exportation' => false, 'description' => 'Venta Interna - NRUS'],
            ['id' => '0200', 'active' => true,  'exportation' => true,  'description' => 'Exportación de Bienes'],
            ['id' => '0201', 'active' => false, 'exportation' => true,  'description' => 'Exportación de Servicios – Prestación servicios realizados íntegramente en el país'],
            ['id' => '0202', 'active' => false, 'exportation' => true,  'description' => 'Exportación de Servicios – Prestación de servicios de hospedaje No Domiciliado'],
            ['id' => '0203', 'active' => false, 'exportation' => true,  'description' => 'Exportación de Servicios – Transporte de navieras'],
            ['id' => '0204', 'active' => false, 'exportation' => true,  'description' => 'Exportación de Servicios – Servicios a naves y aeronaves de bandera extranjera'],
            ['id' => '0205', 'active' => false, 'exportation' => true,  'description' => 'Exportación de Servicios - Servicios que conformen un Paquete Turístico'],
            ['id' => '0206', 'active' => false, 'exportation' => true,  'description' => 'Exportación de Servicios – Servicios complementarios al transporte de carga'],
            ['id' => '0207', 'active' => false, 'exportation' => true,  'description' => 'Exportación de Servicios – Suministro de energía eléctrica a favor de sujetos domiciliados en ZED'],
            ['id' => '0208', 'active' => false, 'exportation' => true,  'description' => 'Exportación de Servicios – Prestación servicios realizados parcialmente en el extranjero'],
            ['id' => '0301', 'active' => false, 'exportation' => false, 'description' => 'Operaciones con Carta de porte aéreo (emitidas en el ámbito nacional)'],
            ['id' => '0302', 'active' => false, 'exportation' => false, 'description' => 'Operaciones de Transporte ferroviario de pasajeros'],
            ['id' => '0303', 'active' => false, 'exportation' => false, 'description' => 'Operaciones de Pago de regalía petrolera'],
            ['id' => '0401', 'active' => false, 'exportation' => false, 'description' => 'Ventas no domiciliados que no califican como exportación'],
            ['id' => '1001', 'active' => false, 'exportation' => false, 'description' => 'Operación Sujeta a Detracción'],
            ['id' => '1002', 'active' => false, 'exportation' => false, 'description' => 'Operación Sujeta a Detracción- Recursos Hidrobiológicos'],
            ['id' => '1003', 'active' => false, 'exportation' => false, 'description' => 'Operación Sujeta a Detracción- Servicios de Transporte Pasajeros'],
            ['id' => '1004', 'active' => false, 'exportation' => false, 'description' => 'Operación Sujeta a Detracción- Servicios de Transporte Carga'],
            ['id' => '2001', 'active' => false, 'exportation' => false, 'description' => 'Operación Sujeta a Percepción'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operation_types');
    }
}
