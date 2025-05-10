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
    <h3 class="mb-4"><b>Oke Toys - Edit Supplier</b></h3>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('update-supplier', $supplier->id ?? '') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_supplier" class="form-label">Nama Supplier</label>
            <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" autocomplete="off" value="{{ isset($supplier) ? $supplier->nama_supplier : '' }}" required>
        </div>
        <div class="mb-3">
            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="{{ isset($supplier) ? $supplier->nomor_telepon : '' }}" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ isset($supplier) ? $supplier->email : '' }}" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ isset($supplier) ? $supplier->alamat : '' }}" autocomplete="off" required>
        </div>
        <button type="submit" class="btn btn-simpan">Simpan</button>
    </form>
</div>
@endsection
