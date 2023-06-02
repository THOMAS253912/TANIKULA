<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable();
            $table->foreignId("province_id")->nullable();
            $table->foreignId("city_id")->nullable();
            $table->foreignId("district_id")->nullable();
            $table->foreignId("village_id")->nullable();
            $table->string("street")->nullable();
            $table->string("number")->nullable();
            $table->bigInteger('phone')->nullable();
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
        Schema::dropIfExists('admins');
    }
}
