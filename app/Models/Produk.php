<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'produk';
    protected $fillable = [
        'nama_produk',
        'foto_produk',
        'id_kategori',
        'stok',
        'harga_modal',
        'persentase_keuntungan',
        'harga_jual'
    ];

    public function kategori(){
        return $this->belongsTo(kategori::class, 'id_kategori');
    }
}
