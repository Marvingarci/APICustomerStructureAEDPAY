<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_catalogs', function (Blueprint $table) {
            $table->id();            
            $table->string('corcusID');
            $table->string('terms');
            $table->string('description');
            $table->double('amount');
            $table->integer('num_month');
            $table->integer('num_payments');
            $table->longText('contract_body');
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
        Schema::dropIfExists('services_catalogs');
    }
}
