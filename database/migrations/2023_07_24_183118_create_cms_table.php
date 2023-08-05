<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_cms', function (Blueprint $table) {
            $table->id('id_cms');
            $table->string('cms_name');
            $table->string('alias')->nullable();
            $table->longText('content');
            $table->boolean('is_image')->default(false);
            $table->boolean('is_multiple')->default(false);
            $table->boolean('is_html')->default(false);
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
        Schema::dropIfExists('t_cms');
    }
}
