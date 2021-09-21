<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_types', function (Blueprint $table) {
            $table->uuid('payId')->primary();
            $table->foreignUuid('primary_acc_pmaID');
            $table->string('fullName');
            $table->string('ccn');
            $table->string('exMonth');
            $table->string('exYear');
            $table->string('ccv');
            $table->string('cardType');
            $table->timestamps();

            $table->foreign('primary_acc_pmaID')->references('pmaID')->on('primary_accs');            $table->engine = "InnoDB";

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_types');
    }
}
