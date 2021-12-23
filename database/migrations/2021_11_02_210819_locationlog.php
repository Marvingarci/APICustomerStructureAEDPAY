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
            $table->uuid('locationId');
            $table->foreignUuid('primaryAccPmaId');
            $table->foreignUuid('paymentTypePayId')->nullable();
            $table->foreignUuid('paymentType2PayId')->nullable();
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
