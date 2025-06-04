<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    use HasFactory;
    protected $table = 'stok_masuk';
    protected $fillable = [
        'tanggal',
        'id_supplier',
        'total',
        'catatan',
        'tanggal_jatuh_tempo',
        'tanggal_bayar',
        'metode_pembayaran',
        'status'
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
}
