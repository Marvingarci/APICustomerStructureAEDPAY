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
            $table->uuid('contractId')->primary();
            $table->foreignUuid('locationAccLocationId');
            $table->foreignUuid('servicesCatalogCorpId');
            $table->string('fullName');
            $table->string('terms');
            $table->string('description');
            $table->double('amount');
            $table->integer('numMonth');
            $table->integer('numPayments');
            $table->longText('contractBody');
            $table->date('startDate');
            $table->date('endDate');
            $table->boolean('status');
            $table->longText('signature')->nullable();
            $table->timestamps();

            $table->foreign('locationAccLocationId')->references('locationId')->on('location_accs');            
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
