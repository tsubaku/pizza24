<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->bigInteger('category_id')->unsigned();
            $table->text('description')->nullable();
            $table->float('price')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_published')->default(false);

            $table->timestamps();

            $table->softDeletes();

            $table->foreign('category_id')
                ->references('id')->on('categories')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

