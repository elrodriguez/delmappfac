<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUnitTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('symbol')->nullable();
            $table->string('description');
            $table->timestamps();
        });

        DB::table('unit_types')->insert([
            ['id' => 'ZZ',  'active' => true, 'symbol' => null, 'description' => 'Servicio'],
            ['id' => 'BX',  'active' => true, 'symbol' => null, 'description' => 'Caja'],
            ['id' => 'GLL', 'active' => true, 'symbol' => null, 'description' => 'Galones'],
            ['id' => 'GRM', 'active' => true, 'symbol' => null, 'description' => 'Gramos'],
            ['id' => 'KGM', 'active' => true, 'symbol' => null, 'description' => 'Kilos'],
            ['id' => 'LTR', 'active' => true, 'symbol' => null, 'description' => 'Litros'],
            ['id' => 'MTR', 'active' => true, 'symbol' => null, 'description' => 'Metros'],
            ['id' => 'FOT', 'active' => true, 'symbol' => null, 'description' => 'Pies'],
            ['id' => 'INH', 'active' => true, 'symbol' => null, 'description' => 'Pulgadas'],
            ['id' => 'NIU', 'active' => true, 'symbol' => null, 'description' => 'Unidades'],
            ['id' => 'YRD', 'active' => true, 'symbol' => null, 'description' => 'Yardas'],
            ['id' => 'HUR', 'active' => true, 'symbol' => null, 'description' => 'Hora'],
            ['id' => 'LBS', 'active' => false, 'symbol' => null, 'description' => 'Libras'],
            ['id' => 'TNP', 'active' => false, 'symbol' => null, 'description' => 'Tinapon'],
            ['id' => 'M36', 'active' => false, 'symbol' => null, 'description' => 'Tonelada'],
            ['id' => 'DZN', 'active' => true, 'symbol' => null, 'description' => 'Docena'],
            ['id' => 'PK', 'active' => true, 'symbol' => null, 'description' => 'Paquete'],
            ['id' => 'PR', 'active' => true, 'symbol' => null, 'description' => 'Par']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_types');
    }
}
