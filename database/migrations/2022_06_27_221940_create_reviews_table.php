<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable();
            $table->foreignId("order_id")->nullable();
            $table->foreignId("product_id")->nullable();
            $table->string("stars_rated")->nullable();
            $table->mediumText("review")->nullable();
            $table->mediumText("reply_review")->nullable();
            $table->boolean('hide')->default(0);
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
        Schema::dropIfExists('reviews');
    }
}
