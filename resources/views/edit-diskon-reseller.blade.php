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
    <h3 class="mb-4"><b>Oke Toys - Edit Diskon Reseller</b></h3>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('update-diskon-reseller') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="diskon_reseller" class="form-label">Diskon Reseller</label>
            <input type="number" max="50" class="form-control" id="diskon_reseller" name="diskon_reseller" value="{{ isset($diskon_reseller) ? $diskon_reseller : '' }}" autocomplete="off" required>
        </div>
        <button type="submit" class="btn btn-simpan">Simpan</button>
    </form>
</div>
@endsection
