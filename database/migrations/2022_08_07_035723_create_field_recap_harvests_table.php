<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldRecapHarvestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_recap_harvests', function (Blueprint $table) {
            $table->id();
            $table->foreignId("planting_id")->nullable();
            $table->foreignId("farmer_id")->nullable();
            $table->dateTime('date_harvest')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('field_recap_harvests');
    }
}
