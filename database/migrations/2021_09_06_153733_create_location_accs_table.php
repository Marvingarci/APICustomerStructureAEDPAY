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
            $table->uuid('locationID')->primary();
            $table->foreignUuid('primary_acc_pmaID');
            $table->foreignUuid('payment_type_payId')->nullable();
            //$table->foreignUuid('contract_contractID')->nullable();
            $table->string('username');
            $table->string('password');
            $table->string('locationName');
            $table->string('companyLegalName');
            $table->string('dbDestination');
            $table->string('locationDestination');
            $table->timestamps();

            $table->foreign('primary_acc_pmaID')->references('pmaID')->on('primary_accs');           
            $table->foreign('payment_type_payId')->references('payId')->on('payment_types');  
            //$table->foreign('contract_contractID')->references('contractID')->on('contracts');  
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
