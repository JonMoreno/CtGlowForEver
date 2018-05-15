<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterClientsTableMakeFielsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->date('dob')->nullable()->change();
            $table->string('street')->nullable()->change();
            $table->string('apt_floor')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('zip')->nullable();
            $table->string('work_phone')->nullable()->change();
            $table->string('emergency_phone')->nullable()->change();
            $table->string('cellular')->nullable()->change();
            $table->string('occupation')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('image')->nullable()->change();
            $table->boolean('first_facial')->nullable()->change();
            $table->string('visit_reason')->nullable()->change();
            $table->string('image')->default("temp_user.png")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
}
