<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable();
            $table->foreignId("gapoktan_id")->nullable();
            $table->foreignId("poktan_id")->nullable();
            $table->foreignId("province_id")->nullable();
            $table->foreignId("city_id")->nullable();
            $table->foreignId("district_id")->nullable();
            $table->foreignId("village_id")->nullable();
            $table->string("street")->nullable();
            $table->string("number")->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(0);
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
        Schema::dropIfExists('farmers');
    }
}
