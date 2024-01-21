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
        Schema::create('barang', function (Blueprint $table) {
            $table->id('id_barang');
            $table->integer('id_kategori');
            $table->string('nama_barang', 150);
            $table->float('harga_jual');
            $table->float('harga_beli');
            $table->string('deskripsi', 250);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('barang');
    }
};
