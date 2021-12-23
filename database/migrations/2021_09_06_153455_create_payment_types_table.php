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
            $table->foreignUuid('primaryAccPmaId');
            $table->string('fullName');
            $table->string('ccn');
            $table->string('address');
            $table->string('address2');
            $table->string('exMonth');
            $table->string('exYear');
            $table->string('city');
            $table->string('state');
            $table->string('ccv');
            $table->string('zip');
            $table->string('phone');
            $table->string('cardType');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('primaryAccPmaId')->references('pmaId')->on('primary_accs');            $table->engine = "InnoDB";

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
