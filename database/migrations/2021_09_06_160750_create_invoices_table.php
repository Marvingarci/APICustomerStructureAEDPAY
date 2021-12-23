<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('invoiceId'); 
            $table->date('Date'); 
            $table->uuid('invoiceNumber'); 
            $table->uuid('statusin'); 
            $table->uuid('contractId'); 
            $table->uuid('locationId'); 
            $table->integer('numPayments_p'); 
            $table->double('TotalInvoice'); 
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
        Schema::dropIfExists('invoices');
    }
}
