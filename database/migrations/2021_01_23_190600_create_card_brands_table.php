<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCardBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_brands', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('description');
            $table->boolean('state')->default(true);
            $table->timestamps();
        });

        DB::table('card_brands')->insert([
            ['id'=>'01', 'description'=>'Visa', 'state'=>1],
            ['id'=>'02', 'description'=>'Mastercard', 'state'=>1]
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_brands');
    }
}
