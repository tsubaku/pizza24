<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();

            $table->string('session_id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->smallInteger('status')->unsigned();
            $table->float('total');
            $table->string('currency');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');

            $table->timestamps();

            $table->softDeletes();
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


