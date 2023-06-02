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
            $table->foreignId("user_id")->nullable();
            $table->foreignId("address_id")->nullable();
            $table->string("code")->unique();
            $table->string("status");
            $table->datetime('order_date');
		    $table->datetime('payment_due');
			$table->string('payment_status');
            $table->bigInteger("total_price")->nullabel();
            $table->unsignedBigInteger('approved_by')->nullable();
			$table->datetime('approved_at')->nullable();
			$table->unsignedBigInteger('cancelled_by')->nullable();
			$table->datetime('cancelled_at')->nullable();
			$table->text('cancellation_note')->nullable();
			$table->string('review')->nullable();
            $table->timestamps();

            $table->foreign('approved_by')->references('id')->on('users');
			$table->foreign('cancelled_by')->references('id')->on('users');
            // $table->tinyInteger("status")->default('0');
            // $table->enum('payment_status', ['1', '2', '3', '4'])->comment('1=menunggu pembayaran, 2=sudah dibayar, 3=kadaluarsa, 4=batal');
            // $table->string('snap_token', 36)->nullable();
            // $table->string("tracking_no")->nullabel();
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
