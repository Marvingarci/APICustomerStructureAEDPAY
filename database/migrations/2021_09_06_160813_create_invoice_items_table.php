<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();            
            $table->integer('invoiceId');           
            $table->integer('itemNumber');             
            $table->text('Description');             
            $table->integer('Qty');          
            $table->integer('Unit'); 
            $table->float('Amount'); 
            $table->float('Subtotal'); 
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
        Schema::dropIfExists('invoice_items');
    }
}
