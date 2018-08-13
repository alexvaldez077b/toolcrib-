<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');

            $table->string('code',15)->unique();

            $table->string('description');
            $table->string('localization')->nullable();
            $table->string('pn')->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('status')->default(false);   //////************************ */
            $table->integer('family')->default(0);
            
            $table->string('umdelivery')->nullable();
            $table->string('umpurchase')->nullable();

            $table->float('price')->default(0);
            $table->integer('packing')->default(1);

            $table->integer('leadtime')->default(15);

            $table->integer('priority')->default(0);

            $table->boolean('currency')->default(1);

            $table->string('image')->nullable();

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
        Schema::dropIfExists('items');
    }
}
