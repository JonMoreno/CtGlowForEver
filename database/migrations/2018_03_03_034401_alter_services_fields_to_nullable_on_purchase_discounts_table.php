<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterServicesFieldsToNullableOnPurchaseDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_discounts', function (Blueprint $table) {
            $table->string('service')->nullable()->change();
            $table->integer('service_id')->nullable()->change();
            $table->decimal('service_original_price', 8, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_discounts', function (Blueprint $table) {
            //
        });
    }
}
