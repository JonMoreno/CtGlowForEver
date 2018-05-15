<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->decimal('total_price', 8, 2);

            $table->integer('client_id')->unsigned();
            $table->integer('consultation_id')->unsigned();
            
            $table->foreign('client_id')
                ->references('id')
                ->on('clients');
                
            $table->foreign('consultation_id')
                ->references('id')
                ->on('consultations');            
            
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
