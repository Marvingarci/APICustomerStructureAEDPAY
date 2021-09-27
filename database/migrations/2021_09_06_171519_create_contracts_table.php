<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('contractID')->primary();
            $table->foreignUuid('location_acc_locationID');
            $table->foreignUuid('services_catalog_corpID');
            $table->string('fullName');
            $table->string('terms');
            $table->string('description');
            $table->double('amount');
            $table->integer('num_month');
            $table->integer('num_payments');
            $table->longText('contract_body');
            $table->date('startDate');
            $table->date('endDate');
            $table->boolean('status');
            $table->longText('signature')->nullable();
            $table->timestamps();

            $table->foreign('location_acc_locationID')->references('locationID')->on('location_accs');            
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
        Schema::dropIfExists('contracts');
    }
}
