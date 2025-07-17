<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Penjualan;
use App\Models\ProdukPenjualan;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'kasir') {
                return redirect()->route('kasir');
            }
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->role === 'kasir') {
                return redirect()->route('kasir');
            }
            
            return redirect()->intended(route('dashboard'));
        }
        
        throw ValidationException::withMessages([
            'email' => 'Login details are not valid',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect(route('login'));
    }
    
    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->role === 'kasir') {
            return redirect()->route('kasir');
        }
        
        if ($user->role !== 'owner') {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }
        
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $penjualanHariIni = 0;
        $penjualanHariIniData = Penjualan::with('produkPenjualan')
            ->whereDate('tanggal', $today)
            ->get();
        
        foreach ($penjualanHariIniData as $penjualan) {
            $subtotal = 0;
            foreach ($penjualan->produkPenjualan as $item) {
                $subtotal += $item->jumlah * $item->harga_jual;
            }
            $penjualanHariIni += $subtotal - $penjualan->diskon;
        }
        
        $transaksiHariIni = Penjualan::whereDate('tanggal', $today)->count();
        
        $untungHariIni = ProdukPenjualan::with(['penjualan', 'produk'])
            ->whereHas('penjualan', function ($query) use ($today) {
                $query->whereDate('tanggal', $today);
            })
            ->get()
            ->sum(function ($item) {
                $hargaModal = $item->harga_modal;
                
                if (!$hargaModal || $hargaModal <= 0) {
                    return 0;
                }
                
                $keuntungan = ($item->harga_jual - $hargaModal) * $item->jumlah;
                
                return $keuntungan;
            });

        $penjualanMingguIni = [];
        $hariMinggu = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        for ($i = 0; $i < 7; $i++) {
            $tanggal = $startOfWeek->copy()->addDays($i);
            $penjualanHari = Penjualan::with('produkPenjualan')
                ->whereDate('tanggal', $tanggal)
                ->get();
            
            $totalHari = 0;
            foreach ($penjualanHari as $penjualan) {
                $subtotal = 0;
                foreach ($penjualan->produkPenjualan as $item) {
                    $subtotal += $item->jumlah * $item->harga_jual;
                }
                $totalHari += $subtotal - $penjualan->diskon;
            }
            
            $penjualanMingguIni[] = $totalHari;
        }

        $penjualanBulanIni = [];
        $currentDate = $startOfMonth->copy();
        $mingguKe = 1;
        
        while ($currentDate <= $endOfMonth && $mingguKe <= 5) {
            $startMinggu = $currentDate->copy()->startOfWeek();
            
            if ($startMinggu < $startOfMonth) {
                $startMinggu = $startOfMonth->copy();
            }
            
            $endMinggu = $startMinggu->copy()->endOfWeek();
            
            if ($endMinggu > $endOfMonth) {
                $endMinggu = $endOfMonth->copy();
            }
            
            $penjualanMinggu = Penjualan::with('produkPenjualan')
                ->whereBetween('tanggal', [
                    $startMinggu->format('Y-m-d'),
                    $endMinggu->format('Y-m-d')
                ])
                ->get();
            
            $totalMinggu = 0;
            foreach ($penjualanMinggu as $penjualan) {
                $subtotal = 0;
                foreach ($penjualan->produkPenjualan as $item) {
                    $subtotal += $item->jumlah * $item->harga_jual;
                }
                $totalMinggu += $subtotal - $penjualan->diskon;
            }
            
            $penjualanBulanIni[] = (float) $totalMinggu;
            
            $currentDate = $endMinggu->copy()->addDay();
            $mingguKe++;
        }
        
        while (count($penjualanBulanIni) < 5) {
            $penjualanBulanIni[] = 0;
        }

        return view('dashboard', [
            'penjualanHariIni' => $penjualanHariIni,
            'transaksiHariIni' => $transaksiHariIni,
            'untungHariIni' => $untungHariIni,
            'penjualanMingguIni' => $penjualanMingguIni,
            'penjualanBulanIni' => $penjualanBulanIni
        ]);
    }
}
