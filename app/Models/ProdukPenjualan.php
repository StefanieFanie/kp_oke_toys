<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProdukPenjualan extends Model
{
    use HasFactory;
    
    protected $table = 'produk_penjualan';
    
    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'jumlah',
        'harga_jual',
        'harga_modal'
    ];

    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
