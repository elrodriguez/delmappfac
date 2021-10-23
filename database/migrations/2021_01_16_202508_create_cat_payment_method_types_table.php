<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCatPaymentMethodTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_payment_method_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->string('description');
            $table->boolean('has_card')->default(true);
            $table->decimal('charge',12,2)->nullable();
            $table->integer('number_days')->nullable();
            $table->timestamps();
        });
        DB::table('cat_payment_method_types')->insert([
            ['id'=>'01','description' => 'Efectivo','has_card'=>0,'charge' => null,'number_days'=> null],
            ['id'=>'02','description' => 'Tarjeta de crédito','has_card'=> 1,'charge' => null,'number_days'=> null],
            ['id'=>'03','description' => 'Tarjeta de débito','has_card'=> 1,'charge' => null,'number_days'=> null],
            ['id'=>'04','description' => 'Transferencia','has_card'=> 0,'charge' => null,'number_days'=> null],
            ['id'=>'05','description' => 'Factura a 30 días','has_card'=> 0,'charge' => null,'number_days'=> 30],
            ['id'=>'06','description' => 'Tarjeta crédito visa','has_card'=> 1,'charge' => '3.68','number_days'=> null],
            ['id'=>'07','description' => 'Contado contraentrega','has_card'=> 0,'charge' => null,'number_days'=> null],
            ['id'=>'08','description' => 'A 30 días','has_card'=> 0,'charge' => null, 'number_days'=> 30],
            ['id'=>'09','description' => 'Crédito','has_card'=> 1,'charge' => null,'number_days'=> null],
            ['id'=>'10','description' => 'Contado','has_card'=> 0,'charge' => null,'number_days'=> null]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_payment_method_types');
    }
}
