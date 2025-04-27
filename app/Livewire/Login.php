<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Login extends Component
{
    public $email = '';
    public $password = '';

    public function mount()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
    }

    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('livewire.login');
    }

    public function render()
    {
        return view('livewire.login')->extends('components.layouts.guest');
    }
    
    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $credentials = [
            'email' => $this->email,
            'password' => $this->password
        ];
        
        if (Auth::attempt($credentials, true)) {
            session()->regenerate();
            
            if (Auth::check()) {
                return redirect()->intended(route('dashboard'));
            }
        }
        
        $this->password = '';
        session()->flash('error', 'Login failed. Incorrect email or password.');
        
        return null;
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
