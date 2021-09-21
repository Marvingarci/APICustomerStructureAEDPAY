<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAedpayMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aedpay_mains', function (Blueprint $table) {
            $table->id();
            $table->integer('comID');
            $table->string('Companyname', 100);
            $table->text('Address');            
            $table->string('City', 50);       
            $table->string('State', 100);       
            $table->string('Zip', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aedpay_mains');
    }
}
