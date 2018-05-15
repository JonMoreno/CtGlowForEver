<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
           
            $table->string('notes')->nullable();
            $table->integer('stress_level')->nullable();
            $table->date('next_appointment')->nullable();
           
            $table->timestamps();
            $table->softDeletes();

            // FOREIGN KEY
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultations');
    }
}
