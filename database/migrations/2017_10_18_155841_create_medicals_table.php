<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            
            $table->boolean('dermatologist');// 3.
            $table->boolean('pregnant');// 4.
            
            // Skin Product: Retin-A.. 5.
            // Medication: Acutane 6.
            
            // Stress Level: Average 7.
            
            // Surgery: Name | Location -> Metal implants 8a -> pacemaker 8b
            
            // Surgery: Name | Location -> Other 9
            
            // Medications Other 10.
            
            $table->boolean('glasses');// 11.
            $table->boolean('smoke');// 12.
            
            // Allergy: 13.
            // Illness: SKin cancer 14.
            // Skin Product: True|False 15a 15b
            
            // Illnesses: [ ]
            
            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');
            
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
        Schema::dropIfExists('medicals');
    }
}
