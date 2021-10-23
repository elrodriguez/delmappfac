<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCurrencyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('symbol')->nullable();
            $table->string('description');
            $table->timestamps();
        });

        DB::table('currency_types')->insert([
            ['id' => 'PEN', 'active' => true, 'symbol' => 'S/', 'description' => 'Soles'],
            ['id' => 'USD', 'active' => true, 'symbol' => '$',  'description' => 'Dólares Americanos'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_types');
    }
}
