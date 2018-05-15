<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStressLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stress_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medical_id')->unsigned();
            $table->integer('stress_level');
            
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
        Schema::dropIfExists('stress_levels');
    }
}
