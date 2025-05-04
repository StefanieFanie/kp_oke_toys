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
    <h3 class="mb-4"><b>Oke Toys - Tambah Produk</b></h3>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('simpan-produk') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select class="form-select" id="id_kategori" name="id_kategori" required>
                <option selected disabled value="">Pilih kategori</option>
                @forelse ($kategori as $item)
                    <option value={{ $item->id }}>{{ $item->nama_kategori }}</option>
                @empty
                    <option selected disabled value="">Belum ada data kategori, tambahkan data kategori terlebih dahulu</option>
                @endforelse
            </select>
        </div>
        <div class="mb-3">
            <label for="foto_produk" class="form-label">Foto Produk</label>
            <input type="file" class="form-control" id="foto_produk" name="foto_produk" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="harga_modal" class="form-label">Harga Modal</label>
            <input type="number" class="form-control" id="harga_modal" name="harga_modal" required>
        </div>
        <div class="mb-3">
            <label for="harga_jual" class="form-label">Harga Jual</label>
            <input type="number" class="form-control" id="harga_jual" name="harga_jual" required>
        </div>
        <button type="submit" class="btn btn-simpan">Simpan</button>
    </form>
</div>
@endsection
