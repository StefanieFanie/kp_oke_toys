<?php

namespace App\Http\Controllers;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    function show(){
        $data=Kategori::all();

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
}
