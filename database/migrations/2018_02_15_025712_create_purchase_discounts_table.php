<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service'); // product | treatments | whole
            $table->integer('service_id'); // product_id | treatment_id | invoice_id
            // service_original_price
            // discount_type
            $table->decimal('discount_price', 8 , 2); //  product.price | treatment.price | invoice.price

            $table->integer('client_id')->unsigned();
            $table->integer('invoice_id')->unsigned();
            $table->integer('discount_id')->unsigned();
            
            $table->foreign('client_id')
                ->references('id')
                ->on('clients');
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices');            
            $table->foreign('discount_id')
                ->references('id')
                ->on('discounts');

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
        Schema::dropIfExists('purchase_discounts');
    }
}
