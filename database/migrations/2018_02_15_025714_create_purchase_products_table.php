<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_products', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('sold_price', 8 , 2);
            $table->integer('client_id')->unsigned();
            $table->integer('invoice_id')->unsigned();
            $table->integer('product_id')->unsigned();
            
            $table->foreign('client_id')
                ->references('id')
                ->on('clients');
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices');            
            $table->foreign('product_id')
                ->references('id')
                ->on('products');

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
        Schema::dropIfExists('purchase_products');
    }
}
