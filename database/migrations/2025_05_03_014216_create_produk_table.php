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
        Schema::create('produk', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('nama_produk')->unique();
            $table->string('foto_produk');
            $table->foreignId('id_kategori')->references('id')->on('kategori');
            $table->integer('stok')->default(0);
            $table->integer('harga_modal');
            $table->integer('harga_jual');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
