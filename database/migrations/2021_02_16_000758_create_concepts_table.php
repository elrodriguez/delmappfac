<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateConceptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concepts', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('percentage',12,2)->nullable();
            $table->tinyInteger('operation')->default(1);
            $table->timestamps();
        });

        DB::table('concepts')->insert([
            ['description' => 'Adelanto','percentage' => 0,'operation' => 0],
            ['description' => 'Prestamo','percentage' => 0,'operation' => 0],
            ['description' => 'Proyecto','percentage' => 0,'operation' => 1],
            ['description' => 'Basico','percentage' => 930,'operation' => 1]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concepts');
    }
}
