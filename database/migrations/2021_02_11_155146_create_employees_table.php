<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->enum('family_burden', ['SI', 'NO'])->default('NO');
            $table->string('curriculum')->nullable();
            $table->unsignedInteger('bank_id')->nullable();
            $table->string('account_number')->nullable();
            $table->string('criminal_record')->nullable();
            $table->string('drivers_license')->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
