<?php

namespace App\Http\Controllers;
use App\Models\kategori;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    function show(){
        $data = Kategori::whereNull('deleted_at')->get();

        return view('kategori.kategori',['kategori'=>$data]);
    }
    public function tambah(){

        return view('kategori.tambah-kategori');

    
 }
    function simpan(Request $request)
    {
        $nama_kategori = $request->nama_kategori;
        
        $kategori_existing = Kategori::withTrashed()->where('nama_kategori', $nama_kategori)->first();
        
        if ($kategori_existing) {
            if (!$kategori_existing->trashed()) {
                return redirect()->back()->with('error', 'Nama kategori sudah ada dalam database.');
            }
            
            $kategori_existing->restore();
            return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan.');
        }

        $data['nama_kategori'] = $nama_kategori;
        Kategori::create($data);

        return redirect()->route('kategori')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($id){
        if (Auth::check()) {
            $data=Kategori::find($id);

        return view('kategori.edit-kategori',['kategori'=>$data]);

        }}

        public function update(Request $request,$id){
            $nama_kategori = $request->nama_kategori;
            $kategori_saat_ini = Kategori::find($id);
            
            if (!$kategori_saat_ini) {
                return redirect()->route('kategori')->with('error', 'Kategori tidak ditemukan.');
            }
            
            $kategori_existing = Kategori::withTrashed()
                ->where('nama_kategori', $nama_kategori)
                ->where('id', '!=', $id)
                ->first();
            
            if ($kategori_existing) {
                if (!$kategori_existing->trashed()) {
                    return redirect()->back()->with('error', 'Nama kategori sudah ada dalam database.');
                }
                
                $kategori_existing->restore();
                $kategori_saat_ini->delete();
                return redirect()->route('kategori')->with('success', 'Kategori berhasil diperbarui.');
            }
            
            $data['nama_kategori'] = $nama_kategori;
            $kategori_saat_ini->update($data);

            return redirect(route('kategori'))->with('success', 'Kategori berhasil diperbarui.');
        }
        
        public function hapus($id){
            $kategori = Kategori::find($id);
            
            if (!$kategori) {
                return redirect()->route('kategori')->with('error', 'Kategori tidak ditemukan.');
            }
            
            $jumlah_produk = $kategori->produk()->whereNull('deleted_at')->count();
            
            if ($jumlah_produk > 0) {
                return redirect()->route('kategori')->with('error', 'Tidak dapat menghapus kategori karena masih terdapat ' . $jumlah_produk . ' produk yang menggunakan kategori ini. Hapus atau ubah kategori produk terlebih dahulu.');
            }
            
            $kategori->delete();
            return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus.');
        }
}
