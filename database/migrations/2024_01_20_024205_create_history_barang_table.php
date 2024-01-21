<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('history_barang', function (Blueprint $table) {
            $table->id('id_history');
            $table->integer('id_barang');
            $table->bigInteger('stok_masuk');
            $table->bigInteger('stok_keluar')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('history_barang');
    }
};
