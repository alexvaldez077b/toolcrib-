<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_models', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('customer_id');
            
            $table->string('np')->unique();
            
            $table->string('family');
            
            $table->integer('required_quantity');

            $table->boolean( 'status' )->default(true);

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
        Schema::dropIfExists('customer_models');
    }
}
