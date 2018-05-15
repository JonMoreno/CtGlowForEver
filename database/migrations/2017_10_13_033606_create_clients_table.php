<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');//2
            $table->string('last_name');//3
            $table->string('mid_initial')->nullable();//4
            $table->date('dob');//5
            $table->string('street');
            $table->string('apt_floor')->nullable();//6
            $table->string('city');//7
            $table->string('state');//8
            $table->char('zip');//9
            $table->string('work_phone')->nullable();//10
            $table->string('emergency_phone')->nullable();//11
            $table->string('cellular');//12
            $table->string('occupation')->nullable();//13
            $table->string('gender');//14
            $table->string('image');//15
            $table->boolean('first_facial');//16
            $table->string('visit_reason');//17
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
        Schema::dropIfExists('clients');
    }
}
