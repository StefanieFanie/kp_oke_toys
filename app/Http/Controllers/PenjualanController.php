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
    public function simpan(Request $request, $id_produk) {    
        $jumlahProduk = (int) $request->jumlah_produk;
        
        if ($jumlahProduk == 0) {
            session()->flash('update_status', 'error');
            session()->flash('update_message', 'Jumlah produk tidak boleh 0');
            return redirect(route('kasir'));
        }
        $produk = session('produk', []);

        $userInputQuantity = $jumlahProduk;
        $product = Produk::find($id_produk);
        $hargaModal = $product->harga_modal;
        $hargaJual = $product->harga_jual;

        $stok = $product->stok;

        if ($userInputQuantity > $stok) {
            session()->flash('update_status', 'error');
            session()->flash('update_message', 'Stok tidak cukup');
            return redirect(route('kasir'));
        }

        $index = null;
        foreach ($produk as $key => $item) {
            if ($item['id_produk'] == $id_produk) {
                $index = $key;
                break;
            }
        }
        
        if ($index !== null) {
            $produk[$index]['jumlah_produk'] += $userInputQuantity;
            $produk[$index]['harga_modal'] = $hargaModal;
            $produk[$index]['harga_jual'] = $hargaJual;
            $produk[$index]['total_harga'] = $produk[$index]['jumlah_produk'] * $hargaJual;
        } else {
            $newProduk = [
                'id_produk' => $id_produk,
                'jumlah_produk' => $userInputQuantity,
                'harga_modal' => $hargaModal,
                'harga_jual' => $hargaJual,
                'total_harga' => $userInputQuantity * $hargaJual,
            ];

            $produk[] = $newProduk;
        }

        session(['produk' => $produk]);
        return redirect(route('kasir'));
    }

    public function hapusSemuaProduk()
    {
        session()->forget('produk');
        session()->flash('update_status', 'success');
        session()->flash('update_message', 'Keranjang berhasil dikosongkan');
        return redirect(route('kasir'));
    }
    
    public function tambahJumlah($id_produk)
    {
        $produk = session('produk', []);
        
        foreach ($produk as $key => $item) {
            if ($item['id_produk'] == $id_produk) {
                $product = Produk::find($id_produk);
                $stok = $product->stok;
                
                if ($produk[$key]['jumlah_produk'] >= $stok) {
                    session()->flash('update_status', 'error');
                    session()->flash('update_message', 'Stok tidak cukup');
                    return redirect(route('kasir'));
                }
                
                $produk[$key]['jumlah_produk'] += 1;
                $produk[$key]['total_harga'] = $produk[$key]['jumlah_produk'] * $produk[$key]['harga_jual'];
                break;
            }
        }
        
        session(['produk' => $produk]);
        return redirect(route('kasir'));
    }
    
    public function kurangJumlah($id_produk)
    {
        $produk = session('produk', []);
        
        foreach ($produk as $key => $item) {
            if ($item['id_produk'] == $id_produk) {
                if ($produk[$key]['jumlah_produk'] > 1) {
                    $produk[$key]['jumlah_produk'] -= 1;
                    $produk[$key]['total_harga'] = $produk[$key]['jumlah_produk'] * $produk[$key]['harga_jual'];
                } else {
                    unset($produk[$key]);
                    $produk = array_values($produk);
                }
                break;
            }
        }
        
        session(['produk' => $produk]);
        return redirect(route('kasir'));
    }
}
