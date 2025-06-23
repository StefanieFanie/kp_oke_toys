<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk_penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->references('id')->on('penjualan');
            $table->foreignId('produk_id')->references('id')->on('produk');
            $table->integer('jumlah');
            $table->integer('harga_jual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_penjualan');
    }
};
