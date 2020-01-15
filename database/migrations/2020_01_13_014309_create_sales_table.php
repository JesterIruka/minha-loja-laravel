<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gateway');
            $table->string('transaction')->nullable();
            $table->decimal('total');
            $table->string('status');
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone');
            $table->string('client_address');
            $table->string('carrier');
            $table->string('shipping_code')->nullable();

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
        Schema::dropIfExists('sales');
    }
}
