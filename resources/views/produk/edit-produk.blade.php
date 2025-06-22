@extends('layout')
@section('title', 'Oke Toys')
<style>
    .btn-simpan {
        background-color: #3B4B7A !important;
        color: white !important;
        font-weight: 600;
        padding: 5px 20px 5px 20px;
        box-shadow: 5px 5px 10px rgb(112, 112, 112);
        margin-top: 10px;
        margin-bottom: 30px;
        float: right;
    }

    .btn-simpan:hover {
        background-color: #2C3245 !important;
        color: white !important;
    }
</style>
@section('content')
<div>
    <h3 class="mb-4"><b>Oke Toys - Edit Produk</b></h3>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('update-produk', $produk->id ?? '') }}" method = "POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" autocomplete="off" value="{{ isset($produk) ? $produk->nama_produk : '' }}" required>
        </div>
        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select class="form-select" id="id_kategori" name="id_kategori" required>
                <option selected disabled value="">Pilih kategori</option>
                @foreach ($kategori as $item)
                    <option value="{{ $item->id }}" {{ isset($produk) && $produk->id_kategori == $item->id ? 'selected' : '' }}>{{ $item->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="foto_produk" class="form-label">Foto Produk</label>
            <input type="file" class="form-control" id="foto_produk" name="foto_produk" accept="image/*">
            <p>Foto sebelumnya: {{ $produk->foto_produk }}</p>
        </div>
        <div class="mb-3">
            <label for="harga_modal" class="form-label">Harga Modal</label>
            <input type="number" class="form-control" id="harga_modal" name="harga_modal" value="{{ isset($produk) ? $produk->harga_modal : '' }}" required>
        </div>
        <div class="mb-3">
            <label for="persentase_keuntungan" class="form-label">Persentase Keuntungan (%)</label>
            <input type="number" class="form-control" id="persentase_keuntungan" name="persentase_keuntungan" required>
        </div>
        <div class="mb-3">
            <label for="harga_jual" class="form-label">Harga Jual</label>
            <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="{{ isset($produk) ? $produk->harga_jual : '' }}" required>
        </div>
        <button type="submit" class="btn btn-simpan">Simpan</button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hargaModalInput = document.getElementById('harga_modal');
        const persentaseKeuntunganInput = document.getElementById('persentase_keuntungan');
        const hargaJual = document.getElementById('harga_jual');

        function hitungHargaJual() {
            const hargaModal = parseInt(hargaModalInput.value) || 0;
            const persentaseKeuntungan = parseInt(persentaseKeuntunganInput.value)/100 || 0;
            hargaJual.value = hargaModal + hargaModal*persentaseKeuntungan;
        }

        hargaModalInput.addEventListener('input', hitungHargaJual);
        persentaseKeuntunganInput.addEventListener('input', hitungHargaJual);
    });
</script>
@endsection
