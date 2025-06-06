<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\kategori;

class ProdukController extends Controller
{
    function show() {
        $data = Produk::orderBy('id', 'desc')->get();
        $kategori = Kategori::all();
        return view('produk.produk', ['produk' => $data, 'kategori' => $kategori]);
    }

    public function tambah() {
        $data = Kategori::all();
        return view('produk.tambah-produk', ['kategori' => $data]);
    }

    function simpan(Request $request) {
        $nama_produk = ucwords(strtolower($request->nama_produk));
        $existingProduct = Produk::withTrashed()->where('nama_produk', $nama_produk)->first();
        if ($existingProduct) {
            if ($existingProduct->trashed()) {
                if ($request->harga_jual < $request->harga_modal) {
                    return redirect()->back()->with('error', 'Harga jual tidak boleh lebih rendah daripada harga modal');
                }
                if ($request->harga_modal == 0 || $request->harga_jual == 0) {
                    return redirect()->back()->with('error', 'Harga tidak boleh 0');
                }
                $existingProduct->restore();
                $existingProduct->update([
                    'foto_produk' => $request->hasFile('foto_produk') ? $request->file('foto_produk')->store('foto','public') : 'foto-produk/image-fill.svg',
                    'id_kategori' => $request->id_kategori,
                    'harga_modal' => $request->harga_modal,
                    'harga_jual' => $request->harga_jual
                ]);
            } else {
                return redirect()->back()->with('error', 'Nama produk sudah ada');
            }
        } else {
            $data['nama_produk'] = ucwords(strtolower($request->nama_produk));
            $data['foto_produk'] = $request->hasFile('foto_produk') ? $request->file('foto_produk')->store('foto','public') : 'foto-produk/image-fill.svg';
            $data['id_kategori'] = $request->id_kategori;
            $data['harga_modal'] = $request->harga_modal;
            $data['harga_jual'] = $request->harga_jual;
            if ($data['harga_jual'] < $data['harga_modal']) {
                return redirect()->back()->with('error', 'Harga jual tidak boleh lebih rendah daripada harga modal');
            }
            if ($data['harga_modal'] == 0 || $data['harga_jual'] == 0) {
                return redirect()->back()->with('error', 'Harga tidak boleh 0');
            }
            $produk = Produk::create($data);
        }
        return redirect(route('produk'))->with('success', 'Data produk berhasil ditambahkan.');
    }

    public function edit($id) {
        $data_kategori = Kategori::all();
        $data_produk = Produk::find($id);
        return view('produk.edit-produk', ['kategori' => $data_kategori, 'produk' => $data_produk]);
    }

    public function update(Request $request, $id) {
        $nama_produk = ucwords(strtolower($request->nama_produk));
        $produk = Produk::withTrashed()->where('nama_produk', $nama_produk)->first();
        if ($produk) {
            if ($produk->trashed()) {
                return redirect()->back()->with(
                    'error', 'Nama produk ini pernah dihapus. Untuk memulihkannya bisa tambah produk dengan nama yang sama'
                );
            }
        }
        $existingProduct = Produk::where('nama_produk', $nama_produk)->where('id', '!=', $id)->first();
        if ($existingProduct) {
            return redirect()->back()->with('error', 'Nama produk sudah ada');
        }
        $data['nama_produk'] = ucwords(strtolower($request->nama_produk));
        $data['foto_produk'] = $request->hasFile('foto_produk') ? $request->file('foto_produk')->store('foto', 'public') : 'foto-produk/image-fill.svg';
        $data['id_kategori'] = $request->id_kategori;
        $data['harga_modal'] = $request->harga_modal;
        $data['harga_jual'] = $request->harga_jual;
        if ($data['harga_jual'] < $data['harga_modal']) {
            return redirect()->back()->with('error', 'Harga jual tidak boleh lebih rendah daripada harga modal');
        }
        if ($data['harga_modal'] == 0 || $data['harga_jual'] == 0) {
            return redirect()->back()->with('error', 'Harga tidak boleh 0');
        }
        Produk::find($id)->update($data);
        return redirect(route('produk'))->with('success', 'Data produk berhasil diperbarui.');
    }

    public function hapus($id) {
        $data_produk = Produk::find($id);
        $data_produk->delete();
        return redirect(route('produk'))->with('success', 'Data produk berhasil dihapus.');
    }

    public function cari(Request $request) {
        $produks = Produk::with('kategori');
        if ($request->filled('cari')) {
            $produks->where('nama_produk', 'like', '%' . $request->cari . '%');
        }
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $produks->where('id_kategori', $request->kategori);
        }
        return view('produk.produk', [
            'produk' => $produks->orderBy('id', 'desc')->get(),
            'kategori' => Kategori::orderBy('id')->get(),
            'selected_kategori' => $request->kategori,
            'cari' => $request->cari
        ]);
    }
}
