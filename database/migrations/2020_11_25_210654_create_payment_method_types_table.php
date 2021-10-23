<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePaymentMethodTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_method_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('description');
            $table->timestamps();
        });
        DB::table('payment_method_types')->insert([
            ['id' => '001', 'active' => true, 'description' => 'Depósito en cuenta'],
            ['id' => '002', 'active' => true, 'description' => 'Giro'],
            ['id' => '003', 'active' => true, 'description' => 'Transferencia de fondos'],
            ['id' => '004', 'active' => true, 'description' => 'Orden de pago'],
            ['id' => '005', 'active' => true, 'description' => 'Tarjeta de débito'],
            ['id' => '006', 'active' => true, 'description' => 'Tarjeta de crédito emitida en el país por una empresa del sistema financiero'],
            ['id' => '007', 'active' => true, 'description' => 'Cheques con la cláusula de "NO NEGOCIABLE", "INTRANSFERIBLES", "NO A LA ORDEN" u otra equivalente, a que se refiere el inciso g) del artículo 5° de la ley'],
            ['id' => '008', 'active' => true, 'description' => 'Efectivo, por operaciones en las que no existe obligación de utilizar medio de pago'],
            ['id' => '009', 'active' => true, 'description' => 'Efectivo, en los demás casos'],
            ['id' => '010', 'active' => true, 'description' => 'Medios de pago usados en comercio exterior'],
            ['id' => '011', 'active' => true, 'description' => 'Documentos emitidos por las EDPYMES y las cooperativas de ahorro y crédito no autorizadas a captar depósitos del público'],
            ['id' => '012', 'active' => true, 'description' => 'Tarjeta de crédito emitida en el país o en el exterior por una empresa no perteneciente al sistema financiero, cuyo objeto principal sea la emisión y administración de tarjetas de crédito'],
            ['id' => '013', 'active' => true, 'description' => 'Tarjetas de crédito emitidas en el exterior por empresas bancarias o financieras no domiciliadas'],
            ['id' => '101', 'active' => true, 'description' => 'Transferencias – Comercio exterior'],
            ['id' => '102', 'active' => true, 'description' => 'Cheques bancarios - Comercio exterior'],
            ['id' => '103', 'active' => true, 'description' => 'Orden de pago simple - Comercio exterior'],
            ['id' => '104', 'active' => true, 'description' => 'Orden de pago documentario - Comercio exterior'],
            ['id' => '105', 'active' => true, 'description' => 'Remesa simple - Comercio exterior'],
            ['id' => '106', 'active' => true, 'description' => 'Remesa documentaria - Comercio exterior'],
            ['id' => '107', 'active' => true, 'description' => 'Carta de crédito simple - Comercio exterior'],
            ['id' => '108', 'active' => true, 'description' => 'Carta de crédito documentario - Comercio exterior'],
            ['id' => '999', 'active' => true, 'description' => 'Otros medios de pago']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_method_types');
    }
}
