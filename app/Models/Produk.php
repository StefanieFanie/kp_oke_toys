<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = [
        'nama_produk',
        'foto_produk',
        'id_kategori',
        'stok',
        'harga_modal',
        'harga_jual'
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
