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
        $data = StokMasuk::orderBy('id', 'desc')->get();
        return view('stok-masuk.pembelian-stok', ['stok_masuk' => $data]);
    }

    public function showInfo($id) {
        $data_supplier = Supplier::all();
        $data_stok_masuk = StokMasuk::find($id);
        $data_produk = Produk::all();
        $data_stok_masuk_produk = $data_stok_masuk->stokMasukProduk;
        return view('stok-masuk.rincian-stok-masuk', [
            'stok_masuk' => $data_stok_masuk,
            'supplier' => $data_supplier,
            'produk' => $data_produk,
            'stok_masuk_produk' => $data_stok_masuk_produk
        ]);
    }

    function selesaikanDanSimpan(Request $request, $id) {
        $data['metode_pembayaran'] = $request->metode_pembayaran;
        $data['tanggal_bayar'] = $request->tanggal_bayar;
        $data['status'] = 1;
        StokMasuk::find($id)->update($data);
        return redirect(route('pembelian-stok'))->with('success', 'Status berhasil diupdate menjadi selesai');
    }

    public function input() {
        $data_supplier = Supplier::all();
        $data_produk = Produk::all();
        $temp_stok_masuk = session('stok_masuk_temp', []);
        $temp_stok_masuk_produk = session('stok_masuk_produk_temp', []);
        $total = session('total', []);
        return view('stok-masuk.form-input-stok-masuk', ['supplier' => $data_supplier, 'produk' => $data_produk, 'temp_stok_masuk' => $temp_stok_masuk, 'temp_stok_masuk_produk' => $temp_stok_masuk_produk]);
    }

    public function tempTambahStokMasuk(Request $request) {
        $supplier = Supplier::find($request->id_supplier);
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
        $isi_session = session()->get('stok_masuk_produk_temp', []);
        $id_produk_input = $request->id_produk;
        $jumlah_input = intval($request->jumlah);
        $sudah_ada_di_session = false;
        foreach ($isi_session as $index => $item) {
            if ($item['id_produk'] == $id_produk_input) {
                $isi_session[$index]['jumlah'] += $jumlah_input;
                $isi_session[$index]['sub_total'] = $item['harga'] * $isi_session[$index]['jumlah'];
                $sudah_ada_di_session = true;
                break;
            }
        }
        if (!$sudah_ada_di_session) {
            $isi_session[] = [
                'id_produk' => $data_produk->id,
                'nama_produk' => $data_produk->nama_produk,
                'harga' => $data_produk->harga_modal,
                'jumlah' => $request->jumlah,
                'sub_total' => ($data_produk->harga_modal) * ($request->jumlah),
            ];
        }
        session()->put('stok_masuk_produk_temp', $isi_session);
        $total = collect($isi_session)->sum('sub_total');
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
        $catatan = $request->catatan_pembayaran;
        $stok_masuk = StokMasuk::create([
            'tanggal' => $temp_stok_masuk['tanggal'],
            'id_supplier' => $temp_stok_masuk['id_supplier'],
            'total' => $total,
            'catatan' => $catatan,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'tanggal_bayar' => $request->tanggal_jatuh_tempo,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => $catatan === 'Cash' ? "1" : "0"
        ]);
        foreach($temp_stok_masuk_produk as $item) {
            StokMasukProduk::create([
                'id_stok_masuk' => $stok_masuk->id,
                'id_produk' => $item['id_produk'],
                'jumlah' => $item['jumlah'],
                'sub_total' => $item['sub_total'],
            ]);
            $stok = Produk::where('id', $item['id_produk'])->value('stok');
            Produk::find($item['id_produk'])->update([
                'stok' => $stok + $item['jumlah']
            ]);
        }
        session()->forget('stok_masuk_temp');
        session()->forget('stok_masuk_produk_temp');
        session()->forget('total');
        return redirect()->route('pembelian-stok');
    }
}
