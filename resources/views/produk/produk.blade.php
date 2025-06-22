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
        width: 300px;
    }

    li .dropdown-item {
        color: #2C3245;
        border: 1px solid #D5E0FF;
        width: 280px !important;
        margin: 5px;
        border-radius: 10px;
        padding: 10px 0 10px 10px;
    }

    li .dropdown-item:hover {
        width: 280px !important;
    }

    th, td {
        background-color: #E4EBFF !important;
        text-align: center !important;
        color: #2C3245 !important;
    }

    .nama-produk {
        max-width: 250px;
        text-align: left !important;
    }

    .btn {
        padding: 0px 8px 3px 8px;
    }

    .btn-tambah-produk {
        background-color: #3B4B7A !important;
        color: white !important;
        font-weight: 600;
        bottom: 30px;
        right: 30px;
        position: fixed;
        padding: 10px 15px 10px 15px;
        box-shadow: 5px 5px 10px rgb(112, 112, 112);
    }

    .btn-tambah-produk:hover{
        background-color: #2C3245 !important;
        color: white;
    }

    .btn-stok-rendah {
        background-color: #3B4B7A !important;
        color: white !important;
        box-shadow: 5px 5px 10px rgb(112, 112, 112);
        float: right;
    }
</style>
@section('content')
<div>
    <h3 class="mb-4">
        <b>Oke Toys - Produk</b>
    </h3>
    <div class="d-flex">
        <form class="input-search" role="search" action="{{ route('cari-produk') }}" method="GET" style="width: 100%;">
            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="#3B4B7A" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
            <input type="text" id="cari" name="cari" class="form-control me-2" placeholder="Cari produk..." value="{{ isset($cari) ? $cari : '' }}" style="height: 49px;">
            <input type="hidden" name="kategori" value="{{ $selected_kategori ?? 'semua' }}">
        </form>&nbsp;
        <form action="{{ route('cari-produk') }}" method="GET">
            <input type="hidden" name="cari" value="{{ $cari ?? '' }}">
            <div class="dropdown">
                <button type="button" class="btn btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="35" fill="#3B4B7A" class="bi bi-funnel" viewBox="0 0 16 16">
                        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                    </svg>
                </button>
                <ul class="dropdown-menu">
                    <li><button class="dropdown-item" type="submit" name="kategori" value="semua">Semua Kategori</button></li>
                    @forelse ($kategori as $item)
                        <li><button class="dropdown-item" type="submit" name="kategori" value="{{ $item->id }}">{{ $item->nama_kategori }}</button></li>
                    @empty
                        <li><button class="dropdown-item" type="button" disabled>Belum ada</button></li>
                    @endforelse
                </ul>
            </div>
        </form>
        <a href="{{ route('stok-rendah') }}" class="btn btn-warning" style="width: 48px; height: 48px; margin-left: 6px; padding-right: 20px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-exclamation-lg" viewBox="0 0 24 16">
                <path d="M7.005 3.1a1 1 0 1 1 1.99 0l-.388 6.35a.61.61 0 0 1-1.214 0zM7 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0"/>
            </svg>
        </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @isset($informasi)
        <h4 class="mb-4">
            <b>{{ $informasi }}</b>
        </h4>
    @endisset
    <div class="table-responsive">
        <table class="table table-bordered border-secondary table-sm">
            <thead>
                <tr>
                    <th scope="col" class="th-color">Nama Produk</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Harga Modal</th>
                    <th scope="col">Harga Jual</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produk as $item)
                    <tr>
                        <td class="nama-produk">{{ $item->nama_produk }}</td>
                        <td>{{ $item->kategori->nama_kategori }}</td>
                        <td>{{ $item->harga_modal }}</td>
                        <td>{{ $item->harga_jual }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            <a class="btn btn-warning" role="button" href="{{ route('edit-produk', $item->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                            <form id="soft-delete-produk-form-{{ $item->id }}" action="{{ route('hapus-produk', $item->id) }}" method="POST" style="display: none">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button class="btn btn-danger" role="button" onclick="konfirmasiHapusProduk({{ $item->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Data produk kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-start">
        {{ $produk->links('pagination::bootstrap-5') }}
    </div>
    <a href="{{ route('tambah-produk') }}" class="btn btn-tambah-produk">+ Tambah Produk</a>
</div>
<script>
    function konfirmasiHapusProduk(id) {
        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus produk ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if(result.isConfirmed) {
                document.getElementById('soft-delete-produk-form-' + id).submit();
            }
        });
    }
</script>
@endsection
