@extends('layout')
@section('title', 'Oke Toys')
<style>
    .waktu {
        width: 200px;
    }

    .input-search {
        position: relative;
    }

    .form-control-search {
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

    th, td {
        background-color: #E4EBFF !important;
        text-align: center !important;
        color: #2C3245 !important;
    }

    .btn-filter-laporan {
        background-color: #3B4B7A !important;
        color: white !important;
        font-weight: 600;
        padding: 10px -5px 10px 0px !important;
        margin-left: 5px;
        width: 230px;
        height: 38px;
    }

    .btn-filter-laporan:hover {
        background-color: #2C3245 !important;
        color: white !important;
    }

    .button-aksi-rincian {
        width: 30px;
        height: 30px;
        border-radius: 5px;
        text-decoration: none;
        color: black;
        background-color: #A1C6FF;
        border:1px solid #8EABFF;
        box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);
    }
</style>
@section('content')
<h3 class="mb-4"><b>Oke Toys - Laporan Penjualan</b></h3>
<br>
<form class="d-flex" role="search" action="{{ route('laporan-penjualan-bulanan') }}" method="GET">
    <div class="container" style="display: flex; justify-content: center; align-items: center;">
        <div class="row">
            <div class="col-md-auto">
                <b>Pilih Bulan</b>
            </div>
            <div class="col-md-auto">
                <select id="bulan" name="bulan" class="form-control me-2" value="{{ isset($bulan) ? $bulan : '' }}" style="width: 200px">
                    @for ($i=1; $i<=12; $i++)
                        <option value="{{ $i }}">{{ date('F',mktime(0,0,0,$i,1)) }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-auto">
                <b>Pilih Tahun</b>
            </div>
            <div class="col-md-auto">
                <select id="tahun" name="tahun" class="form-control me-2" value="{{ isset($tahun) ? $tahun : '' }}" style="width: 200px">
                    @for ($i=2024; $i<=date('Y'); $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-filter-laporan" style="float: right;">Lihat Laporan Penjualan</a>
            </div>
        </div>
    </div>
</form>
<br>
<h4><b>Riwayat Penjualan</b></h4>
<form class="d-flex input-search" role="search" action="{{ route('cari-id-penjualan') }}" method="GET">
    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="#3B4B7A" class="bi bi-search" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
    </svg>
    <input type="number" id="cari" name="cari" class="form-control form-control-search me-2" placeholder="Cari ID penjualan..." value="{{ isset($cari) ? $cari : '' }}" style="height: 49px;">
</form>
<div class="table-responsive">
    <table class="table table-bordered border-secondary table-sm">
        <thead>
            <tr>
                <th scope="col" style="width: 10%;">ID Penjualan</th>
                <th scope="col">Tanggal Penjualan</th>
                <th scope="col">Total Harga</th>
                <th scope="col">Jenis Penjualan</th>
                <th scope="col">Jenis Pelanggan</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        @forelse ($penjualan as $item)
            <tbody>
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    <td>{{ $item->jenis_penjualan }}</td>
                    <td>
                        @if ($item->diskon == 0)
                            Reseller
                        @else
                            Non Reseller
                        @endif
                    </td>
                    <td class="align-middle text-center">
                        <a href="{{ route('rincian-penjualan', $item->id) }}" type="button" class="button-aksi-rincian">
                            <p><b>i</b></p>
                        </a>
                    </td>
                </tr>
            </tbody>
        @empty
        @endforelse
    </table>
    <div class="d-flex justify-content-center">
        {{ $penjualan->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
