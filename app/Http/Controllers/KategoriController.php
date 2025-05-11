<?php

namespace App\Http\Controllers;
use App\Models\Kategori;
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
        $kategori = Kategori::where('nama_kategori', $nama_kategori)->first();

        if ($kategori) {
            return redirect()->back()->with('error', 'Nama kategori sudah ada dalam database.');
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
            $data['nama_kategori'] = $request->nama_kategori;
            Kategori::find($id)->update($data);

            return redirect(route('kategori'));
        }
        
        public function hapus($id){
            $kategori = Kategori::find($id);
            
            if (!$kategori) {
                return redirect()->route('kategori')->with('error', 'Kategori tidak ditemukan.');
            }
            
            $jumlah_produk = $kategori->produk()->where('is_deleted', false)->count();
            
            if ($jumlah_produk > 0) {
                return redirect()->route('kategori')->with('error', 'Tidak dapat menghapus kategori karena masih terdapat ' . $jumlah_produk . ' produk yang menggunakan kategori ini. Hapus atau ubah kategori produk terlebih dahulu.');
            }
            
            $kategori->delete();
            return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus.');
        }
}
