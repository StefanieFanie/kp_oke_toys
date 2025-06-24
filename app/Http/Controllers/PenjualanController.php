<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\kategori;
use App\Models\Penjualan;
use App\Models\ProdukPenjualan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    function show() {
        $data = Produk::orderBy('id', 'desc')->where('stok', '>', 0)->get();
        $kategori = Kategori::all();
        $diskon_reseller = 0;
        $path = 'diskon_reseller.json';
        if (Storage::exists($path)) {
            $file = Storage::get($path);
            $data_json = json_decode($file, true);
            $diskon_reseller = $data_json['diskon_reseller'] ?? 0;
        }
        return view('kasir', ['produk' => $data, 'kategori' => $kategori, 'diskon_reseller' => $diskon_reseller]);
    }

    public function cari(Request $request) {
        $produks = Produk::with('kategori');
        if ($request->filled('cari')) {
            $produks->where('nama_produk', 'like', '%' . $request->cari . '%')->where('stok', '>', 0);
        }
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $produks->where('id_kategori', $request->kategori)->where('stok', '>', 0);
        }
        $diskon_reseller = 0;
        $path = 'diskon_reseller.json';
        if (Storage::exists($path)) {
            $file = Storage::get($path);
            $data_json = json_decode($file, true);
            $diskon_reseller = $data_json['diskon_reseller'] ?? 0;
        }
        return view('kasir', [
            'produk' => $produks->orderBy('id', 'desc')->where('stok', '>', 0)->get(),
            'kategori' => Kategori::orderBy('id')->get(),
            'selected_kategori' => $request->kategori,
            'cari' => $request->cari,
            'diskon_reseller' => $diskon_reseller
        ]);
    }

    public function toggleDiskonReseller(Request $request) {
        $diskon_reseller = 0;
        $path = 'diskon_reseller.json';
        if (Storage::exists($path)) {
            $file = Storage::get($path);
            $data_json = json_decode($file, true);
            $diskon_reseller = $data_json['diskon_reseller'] ?? null;
        } else {
            $diskon_reseller = "File JSON tidak dapat ditemukan";
        }
        $kategori = Kategori::all();
        return view('kasir', [
            'produk' => $produks->orderBy('id', 'desc')->where('stok', '>', 0)->get(),
            'kategori' => Kategori::orderBy('id')->get(),
            'diskon_reseller' => $diskon_reseller
        ]);
    }

    public function simpan(Request $request, $id_produk) {
        $jumlahProduk = (int) $request->jumlah_produk;

        if ($jumlahProduk <= 0) {
            return redirect()->route('kasir')->with('error', 'Jumlah produk tidak boleh 0 atau kurang');
        }

        $produk = session('produk', []);
        $userInputQuantity = $jumlahProduk;
        $product = Produk::find($id_produk);

        if (!$product) {
            return redirect()->route('kasir')->with('error', 'Produk tidak ditemukan');
        }

        $hargaModal = $product->harga_modal;
        $hargaJual = $product->harga_jual;
        $stok = $product->stok;

        $existingInCart = 0;
        foreach ($produk as $item) {
            if ($item['id_produk'] == $id_produk) {
                $existingInCart = $item['jumlah_produk'];
                break;
            }
        }

        if (($existingInCart + $userInputQuantity) > $stok) {
            return redirect()->route('kasir')->with('error', 'Stok tidak cukup (sudah ada '.$existingInCart.' di keranjang, stok tersedia: '.$stok.')');
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
        return redirect()->route('kasir')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }


    public function hapusSemuaProduk()
    {
        session()->forget('produk');
        return redirect()->route('kasir')->with('success', 'Keranjang berhasil dikosongkan');
    }

    public function tambahJumlah($id_produk)
    {
        $produk = session('produk', []);
        $currentQuantity = 0;

        foreach ($produk as $item) {
            if ($item['id_produk'] == $id_produk) {
                $currentQuantity = $item['jumlah_produk'];
                break;
            }
        }

        $product = Produk::find($id_produk);
        $stok = $product->stok;

        if (($currentQuantity + 1) > $stok) {
            return redirect()->route('kasir')->with('error', 'Stok tidak cukup');
        }

        foreach ($produk as $key => $item) {
            if ($item['id_produk'] == $id_produk) {
                $produk[$key]['jumlah_produk'] += 1;
                $produk[$key]['harga_modal'] = $product->harga_modal;
                $produk[$key]['total_harga'] = $produk[$key]['jumlah_produk'] * $produk[$key]['harga_jual'];
                break;
            }
        }

        session(['produk' => $produk]);
        return redirect()->route('kasir')->with('success', 'Jumlah produk berhasil ditambah');
    }


    public function kurangJumlah($id_produk)
    {
        $produk = session('produk', []);
        $product = Produk::find($id_produk);

        foreach ($produk as $key => $item) {
            if ($item['id_produk'] == $id_produk) {
                if ($produk[$key]['jumlah_produk'] > 1) {
                    $produk[$key]['jumlah_produk'] -= 1;
                    $produk[$key]['harga_modal'] = $product->harga_modal;
                    $produk[$key]['total_harga'] = $produk[$key]['jumlah_produk'] * $produk[$key]['harga_jual'];
                } else {
                    unset($produk[$key]);
                    $produk = array_values($produk);
                }
                break;
            }
        }

        session(['produk' => $produk]);
        return redirect()->route('kasir')->with('success', 'Jumlah produk berhasil dikurangi');
    }

    public function pembayaran(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric|min:0',
            'bayar' => 'required|numeric|min:0',
            'jenis_penjualan' => 'required|in:online,offline',
            'diskon' => 'required|numeric|min:0'
        ]);

        $keranjang = session('produk', []);

        if (empty($keranjang)) {
            return redirect()->route('kasir')->with('error', 'Keranjang kosong');
        }

        if ($request->bayar < $request->total) {
            return redirect()->route('kasir')->with('error', 'Jumlah bayar kurang dari total harga');
        }

        $penjualan = Penjualan::create([
            'tanggal' => now()->format('Y-m-d'),
            'total' => $request->total,
            'jenis_penjualan' => $request->jenis_penjualan,
            'user_id' => Auth::id(),
            'diskon' => $request->diskon
        ]);

        foreach ($keranjang as $item) {
            $produk = Produk::find($item['id_produk']);

            if (!$produk) {
                return redirect()->route('kasir')->with('error', 'Produk tidak ditemukan');
            }

            if ($produk->stok < $item['jumlah_produk']) {
                return redirect()->route('kasir')->with('error', 'Stok produk ' . $produk->nama_produk . ' tidak cukup');
            }

            ProdukPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $item['id_produk'],
                'jumlah' => $item['jumlah_produk'],

                'harga_modal' => $item['harga_modal'],
                'harga_jual' => $item['harga_jual']
            ]);

            $produk->stok -= $item['jumlah_produk'];
            $produk->save();
        }

        session()->forget('produk');

        $kembalian = $request->bayar - $request->total;
        return redirect()->route('kasir')->with([
            'success' => 'Pembayaran berhasil diproses',
            'penjualan_id' => $penjualan->id,
            'total' => $request->total,
            'bayar' => $request->bayar,
            'kembalian' => $kembalian,
            'show_payment_success' => true
        ]);
    }

    public function tampilLaporanPenjualan() {
        $data = Penjualan::orderBy('id', 'desc')->paginate(9);
        return view('laporan.laporan-penjualan', ['penjualan' => $data]);
    }

    public function cariIDPenjualan(Request $request) {
        $query = Penjualan::orderBy('id', 'desc');
        if ($request->filled('cari')) {
            $query->where('id', '=', $request->cari);
        }
        $data = $query->paginate(9);
        return view('laporan.laporan-penjualan', [
            'penjualan' => $data,
            'cari' => $request->cari
        ]);
    }

    public function tampilRincianPenjualan($id) {
        $penjualan = Penjualan::find($id);
        $penjualan_produk = ProdukPenjualan::where('penjualan_id', $id)->with('produk')->get();
        $produk = Produk::all();
        $user = User::all();
        $grouped_penjualan_produk = $penjualan_produk->groupBy(function ($item) {
            return $item->id_produk . '-' . $item->harga_jual;
        })->map(function ($group) {
            $firstItem = $group->first();
            $firstItem->jumlah_produk = $group->sum('jumlah_produk');
            return $firstItem;
        });

        return view('laporan.rincian-penjualan', [
            'penjualan' => $penjualan,
            'penjualan_produk' => $grouped_penjualan_produk,
            'produk' => $produk,
            'user' => $user
        ]);
    }

    public function tampilLaporanPenjualanBulanan(Request $request){
        $bulan = $request->input('bulan') ?? '01';
        $tahun = $request->input('tahun') ?? '2024';
        $query = Penjualan::with('produkPenjualan.produk');
        if ($bulan && $tahun){
            $query -> whereMonth('created_at', $bulan) -> whereYear('created_at', $tahun);
        }
        $penjualan = $query->get();
        $omset = $penjualan->sum('total');
        $penjualan_offline = $penjualan->where('jenis_penjualan', '==', 'offline');
        $penjualan_online = $penjualan->where('jenis_penjualan', '==', 'online');
        $total_penjualan_offline = $penjualan->where('jenis_penjualan', '==', 'offline')->sum('total');
        $total_penjualan_online = $penjualan->where('jenis_penjualan', '==', 'online')->sum('total');

        $laba_bersih_offline = 0;
        foreach ($penjualan_offline as $of) {
            foreach ($of -> produkPenjualan as $item) {
                $hargaJual = $item->harga_jual;
                $hargaModal = $item->harga_modal;
                $jumlah = $item->jumlah;
                $laba_bersih_offline += ($hargaJual - $hargaModal) * $jumlah;
            }
        }

        $laba_bersih_online = 0;
        foreach ($penjualan_online as $on) {
            foreach ($on -> produkPenjualan as $item) {
                $hargaJual = $item->harga_jual;
                $hargaModal = $item->harga_modal;
                $jumlah = $item->jumlah;
                $laba_bersih_online += ($hargaJual - $hargaModal) * $jumlah;
            }
        }

        $pdf = PDF::loadView('laporan.laporan-penjualan-bulanan', [
            'penjualan' => $penjualan, $bulan, $tahun,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'omset' => $omset,
            'total_penjualan_offline' => $total_penjualan_offline,
            'total_penjualan_online' => $total_penjualan_online,
            'laba_bersih_offline' => $laba_bersih_offline,
            'laba_bersih_online' => $laba_bersih_online
        ]);

        $pdf -> setPaper('A4', 'portrait');
        return $pdf->stream('laporan-penjualan.pdf');
    }
}
