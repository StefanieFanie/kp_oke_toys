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
        Schema::table('stok_masuk_produk', function (Blueprint $table) {
            $table->dropColumn('sub_total');
            $table->integer('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok_masuk_produk', function (Blueprint $table) {
            $table->integer('sub_total');
            $table->dropColumn('harga');
        });
    }
};
