<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date_opening');
            $table->time('time_opening');
            $table->date('date_closed')->nullable();
            $table->time('time_closed')->nullable();
            $table->decimal('beginning_balance',12,4)->default(0);
            $table->decimal('final_balance',12,4)->default(0);
            $table->decimal('income',12,4)->default(0);
            $table->boolean('state')->default(true);
            $table->string('reference_number',20)->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashes');
    }
}
