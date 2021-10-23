<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->string('id')->index();
            $table->string('description');
            $table->enum('types',['input','output'])->nullable();
            $table->timestamps();
        });
        DB::table('inventory_transactions')->insert([
            ['id' => '02', 'description' => 'Compra nacional', 'types' => 'input'],
            ['id' => '03', 'description' => 'Consignación recibida', 'types' => 'input'],
            ['id' => '05', 'description' => 'Devolución recibida', 'types' => 'input'],
            ['id' => '16', 'description' => 'Inventario inicial', 'types' => 'input'],
            ['id' => '18', 'description' => 'Entrada de importación', 'types' => 'input'],
            ['id' => '19', 'description' => 'Ingreso de producción', 'types' => 'input'],
            ['id' => '20', 'description' => 'Entrada por devolución de producción', 'types' => 'input'],
            ['id' => '21', 'description' => 'Entrada por transferencia entre almacenes', 'types' => 'input'],
            ['id' => '22', 'description' => 'Entrada por identificación erronea', 'types' => 'input'],
            ['id' => '24', 'description' => 'Entrada por devolución del cliente', 'types' => 'input'],
            ['id' => '26', 'description' => 'Entrada para servicio de producción', 'types' => 'input'],
            ['id' => '29', 'description' => 'Entrada de bienes en prestamo', 'types' => 'input'],
            ['id' => '31', 'description' => 'Entrada de bienes en custodia', 'types' => 'input'],
            ['id' => '50', 'description' => 'Ingreso temporal', 'types' => 'input'],
            ['id' => '52', 'description' => 'Ingreso por transformación', 'types' => 'input'],
            ['id' => '54', 'description' => 'Ingreso de producción', 'types' => 'input'],
            ['id' => '55', 'description' => 'Entrada de importación', 'types' => 'input'],
            ['id' => '57', 'description' => 'Entrada por conversión de medida', 'types' => 'input'],
            ['id' => '91', 'description' => 'Ingreso por transformación', 'types' => 'input'],
            ['id' => '93', 'description' => 'Ingreso temporal', 'types' => 'input'],
            ['id' => '96', 'description' => 'Entrada por conversión de medida', 'types' => 'input'],
            ['id' => '99', 'description' => 'Otros', 'types' => 'input'],
            ['id' => '01', 'description' => 'Venta nacional', 'types' => 'output'],
            ['id' => '04', 'description' => 'Consignación entregada', 'types' => 'output'],
            ['id' => '06', 'description' => 'Devolución entregada', 'types' => 'output'],
            ['id' => '07', 'description' => 'Bonificación', 'types' => 'output'],
            ['id' => '08', 'description' => 'Premio', 'types' => 'output'],
            ['id' => '09', 'description' => 'Donación', 'types' => 'output'],
            ['id' => '10', 'description' => 'Salida a producción', 'types' => 'output'],
            ['id' => '11', 'description' => 'Salida por transferencia entre almacenes', 'types' => 'output'],
            ['id' => '12', 'description' => 'Retiro', 'types' => 'output'],
            ['id' => '13', 'description' => 'Mermas', 'types' => 'output'],
            ['id' => '14', 'description' => 'Desmedros', 'types' => 'output'],
            ['id' => '15', 'description' => 'Destrucción', 'types' => 'output'],
            ['id' => '17', 'description' => 'Exportación', 'types' => 'output'],
            ['id' => '23', 'description' => 'Salida por identificación erronea', 'types' => 'output'],
            ['id' => '25', 'description' => 'Salida por devolución al proveedor', 'types' => 'output'],
            ['id' => '27', 'description' => 'Salida por servicio de producción', 'types' => 'output'],
            ['id' => '28', 'description' => 'Ajuste por diferencia de inventario', 'types' => 'output'],
            ['id' => '30', 'description' => 'Salida de bienes en prestamo', 'types' => 'output'],
            ['id' => '32', 'description' => 'Salida de bienes en custodia', 'types' => 'output'],
            ['id' => '33', 'description' => 'Muestras médicas', 'types' => 'output'],
            ['id' => '34', 'description' => 'Publicidad', 'types' => 'output'],
            ['id' => '35', 'description' => 'Gastos de representación', 'types' => 'output'],
            ['id' => '36', 'description' => 'Retiro para entrega a trabajadores', 'types' => 'output'],
            ['id' => '37', 'description' => 'Retiro por convenio colectivo', 'types' => 'output'],
            ['id' => '38', 'description' => 'Retiro por sustitución de bien siniestrado', 'types' => 'output'],
            ['id' => '51', 'description' => 'Salida temporal', 'types' => 'output'],
            ['id' => '53', 'description' => 'Salida para servicios terceros', 'types' => 'output'],
            ['id' => '56', 'description' => 'Salida por conversión de medida', 'types' => 'output'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_transactions');
    }
}
