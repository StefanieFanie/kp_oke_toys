<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StokMasukProduk;
use App\Models\ProdukPenjualan;
use App\Models\Produk;
use App\Models\StokMasuk;
use App\Models\Penjualan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function laporanBarang(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        Carbon::setLocale('id');
        
        $cari = $request->get('cari');
        $jenis = $request->get('jenis', 'semua');
        $tanggalMulai = $request->get('tanggal_mulai');
        $tanggalSelesai = $request->get('tanggal_selesai');
        
        try {
            $laporanBarang = collect();
        
            if ($jenis === 'semua' || $jenis === 'masuk') {
                $transaksiMasuk = StokMasukProduk::with(['stokMasuk', 'produk'])
                    ->when($cari, function ($query) use ($cari) {
                        return $query->whereHas('produk', function ($q) use ($cari) {
                            $q->where('nama_produk', 'LIKE', "%{$cari}%");
                        });
                    })
                    ->when($tanggalMulai && $tanggalSelesai, function ($query) use ($tanggalMulai, $tanggalSelesai) {
                        return $query->whereHas('stokMasuk', function ($q) use ($tanggalMulai, $tanggalSelesai) {
                            $q->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai . ' 23:59:59']);
                        });
                    })
                    ->get()
                    ->map(function ($item) {
                        return (object) [
                            'tanggal' => $item->stokMasuk->created_at,
                            'nama_produk' => $item->produk->nama_produk,
                            'jumlah' => $item->jumlah,
                            'jenis_transaksi' => 'Masuk'
                        ];
                    });
                
                $laporanBarang = $laporanBarang->merge($transaksiMasuk);
            }
            
            if ($jenis === 'semua' || $jenis === 'keluar') {
                $transaksiKeluar = ProdukPenjualan::with(['penjualan', 'produk'])
                    ->when($cari, function ($query) use ($cari) {
                        return $query->whereHas('produk', function ($q) use ($cari) {
                            $q->where('nama_produk', 'LIKE', "%{$cari}%");
                        });
                    })
                    ->when($tanggalMulai && $tanggalSelesai, function ($query) use ($tanggalMulai, $tanggalSelesai) {
                        return $query->whereHas('penjualan', function ($q) use ($tanggalMulai, $tanggalSelesai) {
                            $q->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai . ' 23:59:59']);
                        });
                    })
                    ->get()
                    ->map(function ($item) {
                        return (object) [
                            'tanggal' => $item->penjualan->created_at,
                            'nama_produk' => $item->produk->nama_produk,
                            'jumlah' => $item->jumlah,
                            'jenis_transaksi' => 'Keluar'
                        ];
                    });
                
                $laporanBarang = $laporanBarang->merge($transaksiKeluar);
            }
            
            $laporanBarang = $laporanBarang->sortByDesc('tanggal')->values();

            $laporanBarang = $laporanBarang->map(function ($item) {
                $item->tanggal_formatted = Carbon::parse($item->tanggal)->timezone('Asia/Jakarta')->format('d-m-Y H:i');
                return $item;
            });
            
        } catch (\Exception $e) {
            $laporanBarang = collect();
        }

        return view('laporan.laporan-barang', [
            'laporanBarang' => $laporanBarang,
            'cari' => $cari,
            'jenis' => $jenis,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai
        ]);
    }
    public function downloadLaporanBarangPdf(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        Carbon::setLocale('id');
        
        $cari = $request->get('cari');
        $jenis = $request->get('jenis', 'semua');
        $tanggalMulai = $request->get('tanggal_mulai');
        $tanggalSelesai = $request->get('tanggal_selesai');
        
        $laporanBarang = collect();
    
        if ($jenis === 'semua' || $jenis === 'masuk') {
            $transaksiMasuk = StokMasukProduk::with(['stokMasuk', 'produk'])
                ->when($cari, function ($query) use ($cari) {
                    return $query->whereHas('produk', function ($q) use ($cari) {
                        $q->where('nama_produk', 'LIKE', "%{$cari}%");
                    });
                })
                ->when($tanggalMulai && $tanggalSelesai, function ($query) use ($tanggalMulai, $tanggalSelesai) {
                    return $query->whereHas('stokMasuk', function ($q) use ($tanggalMulai, $tanggalSelesai) {
                        $q->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai . ' 23:59:59']);
                    });
                })
                ->get()
                ->map(function ($item) {
                    return (object) [
                        'tanggal' => $item->stokMasuk->created_at,
                        'nama_produk' => $item->produk->nama_produk,
                        'jumlah' => $item->jumlah,
                        'jenis_transaksi' => 'Masuk'
                    ];
                });
            
            $laporanBarang = $laporanBarang->merge($transaksiMasuk);
        }
        
        if ($jenis === 'semua' || $jenis === 'keluar') {
            $transaksiKeluar = ProdukPenjualan::with(['penjualan', 'produk'])
                ->when($cari, function ($query) use ($cari) {
                    return $query->whereHas('produk', function ($q) use ($cari) {
                        $q->where('nama_produk', 'LIKE', "%{$cari}%");
                    });
                })
                ->when($tanggalMulai && $tanggalSelesai, function ($query) use ($tanggalMulai, $tanggalSelesai) {
                    return $query->whereHas('penjualan', function ($q) use ($tanggalMulai, $tanggalSelesai) {
                        $q->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai . ' 23:59:59']);
                    });
                })
                ->get()
                ->map(function ($item) {
                    return (object) [
                        'tanggal' => $item->penjualan->created_at,
                        'nama_produk' => $item->produk->nama_produk,
                        'jumlah' => $item->jumlah,
                        'jenis_transaksi' => 'Keluar'
                    ];
                });
            
            $laporanBarang = $laporanBarang->merge($transaksiKeluar);
        }
        
        $laporanBarang = $laporanBarang->sortByDesc('tanggal')->values();

        $laporanBarang = $laporanBarang->map(function ($item) {
            $item->tanggal_formatted = Carbon::parse($item->tanggal)->timezone('Asia/Jakarta')->format('d-m-Y H:i');
            return $item;
        });

        $periode = '';
        if ($tanggalMulai && $tanggalSelesai) {
            $mulai = Carbon::parse($tanggalMulai)->format('d-m-Y');
            $selesai = Carbon::parse($tanggalSelesai)->format('d-m-Y');
            $periode = $mulai . ' s/d ' . $selesai;
        } else {
            $periode = 'Semua Periode';
        }

        $totalMasuk = $laporanBarang->where('jenis_transaksi', 'Masuk')->sum('jumlah');
        $totalKeluar = $laporanBarang->where('jenis_transaksi', 'Keluar')->sum('jumlah');
        $totalSemua = $totalMasuk + $totalKeluar;
        $totalData = $laporanBarang->count();
        
        $tanggalCetak = Carbon::now()->timezone('Asia/Jakarta')->translatedFormat('l, d F Y H:i:s');        $pdf = Pdf::loadView('laporan.laporan-barang-pdf', [
            'laporanBarang' => $laporanBarang,
            'periode' => $periode,
            'jenis' => $jenis,
            'cari' => $cari,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'totalSemua' => $totalSemua,
            'totalData' => $totalData,
            'tanggalCetak' => $tanggalCetak
        ]);
        
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('laporan-barang.pdf');
    }
}
