<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMedicalsTableAddNullabelColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medicals', function (Blueprint $table) {
            $table->boolean('dermatologist')->default(0)->change();
            $table->boolean('pregnant')->default(0)->change();
            $table->boolean('glasses')->default(0)->change();
            $table->boolean('smoke')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical', function (Blueprint $table) {
            //
        });
    }
}
