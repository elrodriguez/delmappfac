<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('identity_document_type_id')->nullable();
            $table->string('number',20)->index()->nullable();
            $table->char('soap_type_id', 2)->nullable();
            $table->string('soap_username')->nullable();
            $table->string('soap_password')->nullable();
            $table->string('certificate')->nullable();
            $table->date('certificate_due')->nullable();
            $table->boolean('operation_amazonia')->default(false);
            $table->string('detraction_account')->nullable();
            $table->string('logo_store')->nullable();
            $table->char('soap_send_id', 2)->default('01');
            $table->string('soap_url')->nullable();
            $table->foreign('identity_document_type_id','companies_document_type_id_fky')->references('id')->on('identity_document_types')->onDelete('cascade');
            $table->foreign('soap_type_id','companies_soap_type_id_fky')->references('id')->on('soap_types')->onDelete('cascade');
            $table->foreign('user_id','companies_user_id_fky')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('companies_user_id_fky');
            $table->dropForeign('companies_soap_type_id_fky');
            $table->dropForeign('companies_document_type_id_fky');
            $table->dropColumn('soap_url');
            $table->dropColumn('soap_send_id');
            $table->dropColumn('logo_store');
            $table->dropColumn('detraction_account');
            $table->dropColumn('operation_amazonia');
            $table->dropColumn('certificate_due');
            $table->dropColumn('certificate');
            $table->dropColumn('soap_password');
            $table->dropColumn('soap_username');
            $table->dropColumn('soap_type_id');
            $table->dropColumn('number');
            $table->dropColumn('identity_document_type_id');
            $table->dropColumn('user_id');
        });
    }
}
