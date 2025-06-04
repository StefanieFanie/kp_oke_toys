<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMasukProduk extends Model
{
    use HasFactory;
    protected $table = 'stok_masuk_produk';
    protected $fillable = [
        'id_stok_masuk',
        'id_produk',
        'nama_produk',
        'harga',
        'jumlah',
        'sub_total'
    ];

    public function stokMasuk(){
        return $this->belongsTo(StokMasuk::class, 'id_stok_masuk');
    }

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
