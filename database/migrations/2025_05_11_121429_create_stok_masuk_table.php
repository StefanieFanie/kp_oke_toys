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
        Schema::create('stok_masuk', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('id_supplier')->references('id')->on('supplier');
            $table->integer('total');
            $table->string('catatan');
            $table->date('tanggal_jatuh_tempo');
            $table->date('tanggal_bayar')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_masuk');
    }
};
