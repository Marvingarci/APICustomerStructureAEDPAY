<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorporateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {     
         Schema::create('corporate_customers', function (Blueprint $table) {
            $table->id();
            $table->uuid('CorpID');             
            $table->text('CorpTitle');             
            $table->text('CompanyName');                       
            $table->text('locations');             
            $table->text('dateStarted');  
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
        Schema::dropIfExists('corporate_customers');
    }
}
