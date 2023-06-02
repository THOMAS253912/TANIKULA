<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            // $table->string('name');
            // $table->string('slug')->nullable();
            // $table->longText('description');
            // $table->string('image')->nullable();

            $table->foreignId("user_id")->nullable();
            $table->foreignId("category_activity_id")->nullable();
            $table->string("title")->nullable();
            $table->string("slug")->unique();
            $table->dateTime("date")->nullable();
            $table->text("desc")->nullable();
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
        Schema::dropIfExists('activities');
    }
}
