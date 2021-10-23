<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeConceptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_concepts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('concept_id');
            $table->decimal('amount',12,2)->default(0);
            $table->boolean('state')->default(false);
            $table->date('payment_date')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('employee_id','employee_concepts_employee_id_fk')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('person_id','employee_concepts_person_id_fk')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('concept_id','employee_concepts_concept_id_fk')->references('id')->on('concepts')->onDelete('cascade');
            $table->foreign('user_id','employee_concepts_user_id_fk')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_concepts');
    }
}
