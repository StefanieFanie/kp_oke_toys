<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\StokMasuk;
use App\Models\Supplier;
use App\Models\Produk;
use App\Models\StokMasukProduk;

class StokMasukController extends Controller
{
    function show() {
        $data = StokMasuk::all();
        return view('stok-masuk.stok-masuk', ['stok_masuk' => $data]);
    }

    public function input() {
        $data_supplier = Supplier::all();
        $data_produk = Produk::all();
        $temp_stok_masuk = session('stok_masuk_temp', []);
        $temp_stok_masuk_produk = session('stok_masuk_produk_temp', []);
        return view('stok-masuk.form-input-stok-masuk', ['supplier' => $data_supplier, 'produk' => $data_produk, 'temp_stok_masuk' => $temp_stok_masuk, 'temp_stok_masuk_produk' => $temp_stok_masuk_produk]);
    }

    public function tempTambahStokMasuk(Request $request) {
        $supplier = Supplier::find($request->id_supplier);
        // $temp_stok_masuk = session('stok_masuk_temp', []);
        // $temp_stok_masuk[] = [
        //     'tanggal' => $request->tanggal,
        //     'id_supplier' => $request->id_supplier,
        //     'nama_supplier' => $request->$supplier ? $supplier->nama_supplier : null
        // ];
        // session(['stok_masuk_temp' => $temp_stok_masuk]);
        session([
            'stok_masuk_temp' => [
                'tanggal' => $request->tanggal,
                'id_supplier' => $request->id_supplier,
                'nama_supplier' => $request->$supplier ? $supplier->nama_supplier : null
            ]
        ]);
        return redirect()->route('form-input-stok-masuk');
    }

    public function tempTambah(Request $request) {
        $data_produk = Produk::find($request->id_produk);
        $data = session('stok_masuk_produk_temp', []);
        $data[] = [
            'id_produk' => $data_produk->id,
            'nama_produk' => $data_produk->nama_produk,
            'harga' => $data_produk->harga_modal,
            'jumlah' => $request->jumlah,
            'sub_total' => ($data_produk->harga_modal) * ($request->jumlah),
        ];
        session(['stok_masuk_produk_temp' => $data]);
        $total = collect($data)->sum('sub_total');
        session(['total' => $total]);
        return redirect()->route('form-input-stok-masuk');
    }

    public function tempUpdate(Request $request) {
        $data = session('stok_masuk_produk_temp', []);
        $id_produk_req = $request->id_produk;
        foreach ($data as $index => $item) {
            if ($item['id_produk'] == $request->id_produk) {
                $data[$index]['jumlah'] = $request->jumlah;
                $data[$index]['sub_total'] = $item['harga'] * $request->jumlah;
            }
        }
        session(['stok_masuk_produk_temp' => $data]);
        $total = collect($data)->sum('sub_total');
        session(['total' => $total]);
        return redirect()->route('form-input-stok-masuk');
    }

    public function tempHapus(Request $request) {
        $data = session('stok_masuk_produk_temp', []);
        unset($data[$request->index]);
        session(['stok_masuk_produk_temp' => array_values($data)]);
        $total = collect($data)->sum('sub_total');
        session(['total' => $total]);
        return redirect()->route('form-input-stok-masuk');
    }

    public function simpan(Request $request) {
        $temp_stok_masuk = Session::get('stok_masuk_temp');
        $total = Session::get('total');
        $temp_stok_masuk_produk = session('stok_masuk_produk_temp', []);
        if (empty($temp_stok_masuk) || empty($temp_stok_masuk_produk)) {
            return back()->with('error', 'Tidak ada');
        }
        $stok_masuk = StokMasuk::create([
            'tanggal' => $temp_stok_masuk['tanggal'],
            'id_supplier' => $temp_stok_masuk['id_supplier'],
            'catatan' => $request->catatan_pembayaran,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'total' => $total
        ]);
        foreach($temp_stok_masuk_produk as $item) {
            StokMasukProduk::create([
                'id_stok_masuk' => $stok_masuk->id,
                'id_produk' => $item['id_produk'],
                'jumlah' => $item['jumlah'],
                'sub_total' => $item['sub_total'],
            ]);
        }
        session()->forget('stok_masuk_produk_temp');
        return redirect()->route('stok-masuk');
    }
}
