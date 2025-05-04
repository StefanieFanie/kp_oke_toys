@extends('layout')
@section('title', 'Oke Toys')
<style>
    .input-search {
        position: relative;
    }

    .form-control {
        padding-left: 42px !important;
    }

    .bi-search {
        transform: translateY(-50%);
        left: 10px;
        top: 23px;
        position: absolute;
    }

    .dropdown-menu {
        background-color: #ffffff;
    }

    li .dropdown-item {
        color: #2C3245;
        border: 1px solid #D5E0FF;
        width: 200px;
        margin: 5px;
        border-radius: 10px;
        padding: 10px 0 10px 10px;
    }

    li .dropdown-item:hover {
        width: 200px;
    }

    th, td {
        background-color: #E4EBFF !important;
        text-align: center !important;
        color: #2C3245 !important;
    }

    .btn {
        padding: 0px 8px 3px 8px;
    }

    .btn-download {
        background-color: #3B4B7A !important;
        color: white !important;
        font-weight: 600;
        padding: 10px 15px 10px 15px !important;
        margin-left: 10px;
    }

    .btn-download:hover {
        background-color: #2C3245 !important;
        color: white !important;
    }

    .alert {
        padding: 0 !important;
        width: 70px;
        margin: auto !important;
    }
</style>
@section('content')
<h3 class="mb-4"><b>Oke Toys - Laporan Barang</b></h3>
<form class="d-flex input-search" role="search">
    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="#3B4B7A" class="bi bi-search" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
    </svg>
    <input class="form-control me-2" type="search" placeholder="Cari laporan barang..." aria-label="Search">
    <div class="dropdown">
        <button type="button" class="btn btn-light" data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="35" fill="#3B4B7A" class="bi bi-funnel" viewBox="0 0 16 16">
                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
            </svg>
        </button>
        <ul class="dropdown-menu">
            <li><button class="dropdown-item" type="button">Transaksi Masuk</button></li>
            <li><button class="dropdown-item" type="button">Transaksi Keluar</button></li>
        </ul>
    </div>
    <a href="#" class="btn btn-download">Download</a>
</form>
<div class="table-responsive">
    <table class="table table-bordered border-secondary table-sm">
        <thead>
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Jenis Transaksi</th>
                <th scope="col">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>xx-xx-xxxx</td>
                <td>xxx</td>
                <td>
                    <div class="alert alert-danger">Keluar</div>
                </td>
                <td>5</td>
            </tr>
            <tr>
                <td>xx-xx-xxxx</td>
                <td>xxx</td>
                <td>
                    <div class="alert alert-success">Masuk</div>
                </td>
                <td>12</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
