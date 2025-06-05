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
        Schema::create('stok_masuk_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_stok_masuk')->references('id')->on('stok_masuk');
            $table->foreignId('id_produk')->references('id')->on('produk');
            $table->integer('jumlah');
            $table->integer('sub_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_masuk_produk');
    }
};
