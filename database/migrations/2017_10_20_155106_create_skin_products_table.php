<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkinProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skin_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medical_id')->unsigned();
            $table->string('name');
            
            $table->foreign('medical_id')
                  ->references('id')
                  ->on('medicals');
                  //->onDelete('cascade');
            
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('skin_products');
    }
}
