<?php

namespace App\Livewire\Produk;

use Livewire\Component;
use App\Models\produk as ProdukModel;

class Produk extends Component
{
    public $produkList = [];

    public function mount() {
        $this->loadProduk();
    }

    public function loadProduk() {
        $this->produkList = ProdukModel::all();
    }

    public function render()
    {
        return view('livewire.produk.produk', [
            'list_produk' => $this->produkList
        ]);
    }
}
