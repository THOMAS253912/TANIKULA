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
            $table->foreignId("category_product_id")->nullable();
            $table->foreignId("user_id")->nullable();
            $table->string("name")->nullable();
            $table->string("slug")->unique();
            $table->string("image")->nullable();
            $table->string("code")->unique();
            $table->bigInteger("weight")->nullable();
            $table->bigInteger("stoke")->nullable();
            $table->bigInteger("stock_out")->nullable();
            $table->bigInteger("price")->nullable();
            $table->bigInteger("discount")->default(0);
            $table->bigInteger("price_discount")->nullable();
            $table->text("desc")->nullable();
            $table->boolean('is_active')->default(0);
            // $table->boolean("is_active")->nullable();
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
        Schema::dropIfExists('products');
    }
}
