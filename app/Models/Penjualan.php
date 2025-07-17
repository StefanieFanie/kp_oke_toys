<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penjualan extends Model
{
    use HasFactory;
    
    protected $table = 'penjualan';
    
    protected $fillable = [
        'tanggal',
        'jenis_penjualan',
        'user_id',
        'diskon'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function produkPenjualan(): HasMany
    {
        return $this->hasMany(ProdukPenjualan::class);
    }

    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'produk_penjualan')
                    ->withPivot('jumlah', 'harga_jual')
                    ->withTimestamps();
    }
}
