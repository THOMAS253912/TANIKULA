<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable();
            $table->string('recipients_name')->nullable(); // nama penerima
            $table->string('telp')->nullable(); // telepon penerima
            $table->string('address_label')->nullable(); // label alamat (contoh rumah, kantor)
            // $table->string('city')->nullable(); // kota kabupaten
            $table->foreignId("province_id")->nullable();
            $table->foreignId("city_id")->nullable();
            $table->foreignId("district_id")->nullable();
            $table->foreignId("village_id")->nullable();
            $table->integer('postal_code')->nullable(); // kode pos
            $table->boolean('main_address')->default(0); // Alamat Utama
            $table->string('complete_address')->nullable(); // alamat lengkap
            $table->string('note_for_courier')->nullable(); // catatan untuk kurir(contoh warna rumah, patokan, catatan khusus, )
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
        Schema::dropIfExists('addresses');
    }
}
