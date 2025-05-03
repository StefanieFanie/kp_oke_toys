<?php

namespace App\Livewire\Kategori;

use Livewire\Component;
use App\Models\kategori as KategoriModel;

class Kategori extends Component
{
    public $kategoriList = [];
    
    public function mount()
    {
        $this->loadKategori();
    }
    
    public function loadKategori()
    {
        $this->kategoriList = KategoriModel::all();
    }
    
    public function render()
    {
        return view('livewire.kategori.kategori', [
            'kategori' => $this->kategoriList
        ]);
    }
}
