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

    li .dropdown-item.active {
        background-color: #3B4B7A !important;
        color: white !important;
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
        padding: 10px 20px 10px 20px !important;
        margin-left: 10px;
        min-width: 160px;
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

    .form-control[type="date"] {
        padding: 10px !important;
        border-radius: 8px;
        border: 1px solid #D5E0FF;
    }

    .form-control[type="date"]:focus {
        border-color: #3B4B7A;
        box-shadow: 0 0 0 0.2rem rgba(59, 75, 122, 0.25);
    }

    .modal-footer .btn {
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@section('content')
<h3 class="mb-4"><b>Oke Toys - Laporan Barang</b></h3>
<form class="d-flex input-search" role="search" method="GET" action="{{ route('laporan-barang') }}">
    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="#3B4B7A" class="bi bi-search" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
    </svg>
    <input class="form-control me-2" type="search" name="cari" value="{{ $cari ?? '' }}" placeholder="Cari laporan barang..." aria-label="Search">
    <div class="dropdown">
        <button type="button" class="btn btn-light" data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="35" fill="#3B4B7A" class="bi bi-funnel" viewBox="0 0 16 16">
                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
            </svg>
        </button>
        <ul class="dropdown-menu">
            <li><button class="dropdown-item {{ ($jenis ?? 'semua') == 'semua' ? 'active' : '' }}" type="button" onclick="filterJenis('semua')">Semua Transaksi</button></li>
            <li><button class="dropdown-item {{ ($jenis ?? 'semua') == 'masuk' ? 'active' : '' }}" type="button" onclick="filterJenis('masuk')">Transaksi Masuk</button></li>
            <li><button class="dropdown-item {{ ($jenis ?? 'semua') == 'keluar' ? 'active' : '' }}" type="button" onclick="filterJenis('keluar')">Transaksi Keluar</button></li>
        </ul>
    </div>
    <input type="hidden" name="jenis" id="jenis-filter" value="{{ $jenis ?? 'semua' }}">
    <button type="button" class="btn btn-download d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#downloadModal" style="justify-content: center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download me-2" viewBox="0 0 16 16">
            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
        </svg>
        Download
    </button>
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
            @forelse($laporanBarang as $item)
            <tr>
                <td>{{ $item->tanggal_formatted }}</td>
                <td>{{ $item->nama_produk }}</td>
                <td>
                    @if($item->jenis_transaksi == 'Masuk')
                        <div class="alert alert-success">Masuk</div>
                    @else
                        <div class="alert alert-danger">Keluar</div>
                    @endif
                </td>
                <td>{{ $item->jumlah }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data laporan barang</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="downloadModalLabel">Download Laporan Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('laporan-barang-pdf') }}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="downloadJenis" class="form-label">Jenis Transaksi</label>
                        <select class="form-select" name="jenis" id="downloadJenis">
                            <option value="semua">Semua Transaksi</option>
                            <option value="masuk">Transaksi Masuk</option>
                            <option value="keluar">Transaksi Keluar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="downloadTanggalMulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="tanggal_mulai" id="downloadTanggalMulai">
                        <small class="form-text text-muted">Kosongkan untuk semua periode</small>
                    </div>
                    <div class="mb-3">
                        <label for="downloadTanggalSelesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="tanggal_selesai" id="downloadTanggalSelesai">
                        <small class="form-text text-muted">Kosongkan untuk semua periode</small>
                    </div>
                    <input type="hidden" name="cari" value="{{ $cari ?? '' }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-download">Download</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function filterJenis(jenis) {
    document.getElementById('jenis-filter').value = jenis;
    const form = document.querySelector('form[role="search"]');
    if (form) {
        form.method = 'GET';
        form.action = '{{ route("laporan-barang") }}';
        form.submit();
    }
}
</script>
@endsection
