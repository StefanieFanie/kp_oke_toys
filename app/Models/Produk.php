<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'harga_jual'
    ];

    public function kategori(){
        return $this->belongsTo(kategori::class, 'id_kategori');
    }

    public function produkPenjualan(): HasMany
    {
        return $this->hasMany(ProdukPenjualan::class);
    }

    public function penjualan()
    {
        return $this->belongsToMany(Penjualan::class, 'produk_penjualan')
                    ->withPivot('jumlah', 'harga_jual', 'harga_modal')
                    ->withTimestamps();
    }
}
