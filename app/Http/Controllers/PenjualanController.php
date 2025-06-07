<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\kategori;

class PenjualanController extends Controller
{
    function show() {
        $data = Produk::orderBy('id', 'desc')->where('stok', '>', 0)->get();
        $kategori = Kategori::all();
        return view('kasir', ['produk' => $data, 'kategori' => $kategori]);
    }

    public function cari(Request $request) {
        $produks = Produk::with('kategori');
        if ($request->filled('cari')) {
            $produks->where('nama_produk', 'like', '%' . $request->cari . '%')->where('stok', '>', 0);
        }
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $produks->where('id_kategori', $request->kategori)->where('stok', '>', 0);
        }
        return view('kasir', [
            'produk' => $produks->orderBy('id', 'desc')->where('stok', '>', 0)->get(),
            'kategori' => Kategori::orderBy('id')->get(),
            'selected_kategori' => $request->kategori,
            'cari' => $request->cari
        ]);
    }
}
