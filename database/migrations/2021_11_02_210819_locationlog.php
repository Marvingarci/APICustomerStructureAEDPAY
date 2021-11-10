<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Locationlog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations_log', function (Blueprint $table) {
            $table->uuid('locationID');
            $table->foreignUuid('primary_acc_pmaID');
            $table->foreignUuid('payment_type_payId')->nullable();
            $table->foreignUuid('payment_type2_payId')->nullable();
            $table->string('username');
            $table->string('password');
            $table->string('locationName');
            $table->string('companyLegalName');
            $table->string('dbDestination');
            $table->string('locationDestination');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('primary_acc_pmaID')->references('pmaID')->on('primary_accs');           
            $table->foreign('payment_type_payId')->references('payId')->on('payment_types');  
            $table->foreign('payment_type2_payId')->references('payId')->on('payment_types');  
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
        //
    }
}
