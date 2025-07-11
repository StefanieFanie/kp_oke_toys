<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_kategori'
    ];
    
    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori');
    }
}