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
            return redirect(route('dashboard'));
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
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $penjualanHariIni = Penjualan::whereDate('tanggal', $today)->sum('total');
        
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
            $total = Penjualan::whereDate('tanggal', $tanggal)->sum('total');
            $penjualanMingguIni[] = $total;
        }

        $penjualanBulanIni = [];
        for ($minggu = 1; $minggu <= 5; $minggu++) {
            $startMinggu = $startOfMonth->copy()->addWeeks($minggu - 1);
            $endMinggu = $startMinggu->copy()->addDays(6);
            
            if ($endMinggu->month != $startOfMonth->month) {
                $endMinggu = $endOfMonth->copy();
            }
            
            $total = Penjualan::whereBetween('tanggal', [$startMinggu, $endMinggu])->sum('total');
            $penjualanBulanIni[] = $total;
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
