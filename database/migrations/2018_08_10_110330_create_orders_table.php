<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name'); //quien

            
            $table->unsignedInteger('id_auth');
            
            $table->unsignedInteger('id_cliente');
            $table->unsignedInteger('id_model');
            $table->unsignedInteger('id_item');
            $table->float('quantity')->default(0);
            $table->float('delivered')->nullable();
            
            $table->integer('status')->default(0); //0 - open ; 1- close; 2- no stock

            //$table->unsignedInteger('item_id');
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
        Schema::dropIfExists('orders');
    }
}
