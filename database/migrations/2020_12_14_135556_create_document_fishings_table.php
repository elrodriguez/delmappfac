<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentFishingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_fishings', function (Blueprint $table) {
            $table->id();
            $table->string('code_id');
            $table->string('serie');
            $table->string('numero');
            $table->string('transfer_description',500)->nullable();
            $table->string('observations',500)->nullable();
            $table->string('departure_address')->nullable();
            $table->string('arrival_address')->nullable();
            $table->string('company_number')->nullable();
            $table->string('company_description')->nullable();
            $table->string('driver_number')->nullable();
            $table->string('driver_plaque')->nullable();
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('mode_of_travel');
            $table->string('reason_for_transfer');
            $table->string('measure_id');
            $table->char('departure_country_id', 2);
            $table->char('departure_department_id', 2)->nullable();
            $table->char('departure_province_id', 4)->nullable();
            $table->char('departure_district_id', 6)->nullable();
            $table->char('arrival_country_id', 2);
            $table->char('arrival_department_id', 2)->nullable();
            $table->char('arrival_province_id', 4)->nullable();
            $table->char('arrival_district_id', 6)->nullable();
            $table->string('company_document_type_id');
            $table->string('driver_document_type_id');
            $table->decimal('weight', 12, 2)->default(0);
            $table->decimal('packages', 12, 2)->default(0);
            $table->date('date_of_issue');
            $table->date('date_of_transfer');
            $table->timestamps();
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('mode_of_travel')->references('id')->on('transport_mode_types')->onDelete('cascade');
            $table->foreign('reason_for_transfer')->references('id')->on('transfer_reason_types')->onDelete('cascade');
            $table->foreign('measure_id')->references('id')->on('unit_types')->onDelete('cascade');
            $table->foreign('company_document_type_id')->references('id')->on('identity_document_types');
            $table->foreign('driver_document_type_id')->references('id')->on('identity_document_types');
            $table->foreign('departure_country_id')->references('id')->on('countries');
            $table->foreign('departure_department_id')->references('id')->on('departments');
            $table->foreign('departure_province_id')->references('id')->on('provinces');
            $table->foreign('departure_district_id')->references('id')->on('districts');
            $table->foreign('arrival_country_id')->references('id')->on('countries');
            $table->foreign('arrival_department_id')->references('id')->on('departments');
            $table->foreign('arrival_province_id')->references('id')->on('provinces');
            $table->foreign('arrival_district_id')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_fishings');
    }
}
