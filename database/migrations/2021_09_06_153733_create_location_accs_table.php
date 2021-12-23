<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationAccsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_accs', function (Blueprint $table) {
            $table->uuid('locationId')->primary();
            $table->foreignUuid('primaryAccPmaId');
            $table->foreignUuid('paymentTypePayId')->nullable();
            $table->foreignUuid('paymentType2PayId')->nullable();
            //$table->foreignUuid('contract_contractId')->nullable();
            $table->string('username');
            $table->string('password');
            $table->string('locationName');
            $table->string('companyLegalName');
            $table->string('dbServer');
            $table->string('locationDestination');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('primaryAccPmaId')->references('pmaId')->on('primary_accs');           
            $table->foreign('paymentTypePayId')->references('payId')->on('payment_types');  
            $table->foreign('paymentType2PayId')->references('payId')->on('payment_types');  
            //$table->foreign('contract_contractId')->references('contractId')->on('contracts');  
            $table->engine = "InnoDB";          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_accs');
    }
}
