@extends('layout')
@section('title', 'Oke Toys')

@section('content')
<style>
    .table {
        --bs-table-bg: transparent !important;
        background-color: transparent !important;
    }

    .thead{
        background-color: transparent !important;
    }
=
    .table-responsive::-webkit-scrollbar {
       display: none;
    }

    .table-responsive {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .card-body::-webkit-scrollbar {
        display: none;
    }

    .card-body {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .input-search {
        position: relative;
    }

    .form-control {
        padding-left: 40px !important;
    }

    .bi-search {
        transform: translateY(-70%);
        left: 10px;
        top: 23px;
        position: absolute;
        width: 23px;
        height: 23px;
    }

    .dropdown-menu-end {
        background-color: #ffffff;
        width: 300px;
    }

    li .dropdown-item-2 {
        color: #2C3245;
        border: 1px solid #D5E0FF;
        width: 280px !important;
        margin: 5px;
        border-radius: 10px;
        padding: 10px 0 10px 10px;
        text-align: left;
        background-color: white;
    }

    li .dropdown-item-2:hover {
        width: 280px !important;
        background-color: #D5E0FF !important;
    }

    .form-control-sm {
        border: none;
    }

    @media (max-width: 768px) {
        .grid-kiri {
            margin-bottom: 60px;
        }
    }
</style>
<div class="d-flex flex-column " style="height: calc(100% - 64px);">
    <div class="row align-items-center">
        <div class="col-md-4">
            <h3 class=" text-dark"><b>Oke Toys - Kasir</b></h3>
        </div>
        <div class="col-md-4 d-flex justify-content-end ">
            <div class="d-flex align-items-center me-3">
                <span class="me-2"><b>Diskon reseller</b></span>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="diskonReseller" style="width: 48px; height: 24px;">
                </div>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-2"><b>Pesanan Online</b></span>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="pesananOnline" style="width: 48px; height: 24px;">
                </div>
            </div>
        </div>
        <div class="col-md-4 p-0 ps-md-2 pe-3">
        </div>
    </div>

    <div class="row flex-grow-1 ">
        <div class="col-md-8 pe-md-2">
            <div class="mb-3 d-flex">
                <div class="input-group flex-grow-1 me-2"style="border:1px solid #8EABFF; background-color:#F4F7FF; border-radius:7px;">
                    <form class="input-search" role="search" action="{{ route('kasir') }}" method="GET" style="width:100%">
                        <i class="bi bi-search"></i>
                        <input type="text" id="cari" name="cari" class="form-control border-start-0" placeholder="Cari produk..." aria-label="Search products" value="{{ isset($cari) ? $cari : '' }}">
                        <input type="hidden" name="kategori" value="{{ $selected_kategori ?? 'semua' }}">
                    </form>
                </div>

                <form action="{{ route('kasir') }}" method="GET">
                    <input type="hidden" name="cari" value="{{ $cari ?? '' }}">
                    <div class="dropdown">
                        <button class="btn btn-light" style="border:1px solid #8EABFF; background-color:#F4F7FF;" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                            <li><button class="dropdown-item-2" type="submit" name="kategori" value="semua">Semua Kategori</button></li>
                            @forelse ($kategori as $item)
                                <li><button class="dropdown-item-2" type="submit" name="kategori" value="{{ $item->id }}">{{ $item->nama_kategori }}</button></li>
                            @empty
                                <li><button class="dropdown-item-2" type="button" disabled>Belum ada kategori</button></li>
                            @endforelse
                        </ul>
                    </div>
                </form>

            </div>

            <div class="card grid-kiri" style="border-radius: 15px; border: 1px solid #8EABFF; background-color: #E4EBFF;box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25); height: calc(100vh - 162px); overflow: hidden;">
                <div class="card-body p-0">
                    <div class="table-responsive" style="height: calc(100% - 10px); max-height: calc(100vh - 172px); overflow-y: auto; border-radius: 8px;">
                        <table class="table table-borderless bg-white mb-0">
                            <thead style="position: sticky; top: 0; background-color: #E4EBFF;">
                                <tr>
                                    <th class="py-3 text-center">Foto Produk</th>
                                    <th class="py-3 text-center">Nama Produk</th>
                                    <th class="py-3 text-center">Stok</th>
                                    <th class="py-3 text-center">Harga</th>
                                    <th class="py-3 text-center">Jumlah</th>
                                    <th class="py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produk as $item)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <img src="{{ asset('storage/' . $item->foto_produk) }}" width="50px" height="50px">
                                        </td>
                                        <td class="align-middle text-center">{{ $item->nama_produk }}</td>
                                        <td class="align-middle text-center">{{ $item->stok }}</td>
                                        <td class="align-middle text-center">Rp {{ $item->harga_jual }}</td>
                                        <td class="align-middle text-center" style="width: 100px;">
                                            <input type="number" class="form-control-sm text-center" value="0" min="0" style="width: 60px; margin: 0 auto;">
                                        </td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-md" style="background-color: #A1C6FF; border:1px solid #8EABFF;box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);">
                                                <i class="bi bi-basket"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 ps-md-2" style="height: calc(100vh - 168px);">
            <div class="card" style="border-radius:15px; border: 1px solid #8EABFF; margin-top: -41px;height: calc(100vh - 66px);box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style=" background-color: #3B4B7A; padding: 12px 15px; border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0">Daftar Pesanan</h5>
                    <button class="btn btn-sm btn-danger" style="box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>

                <div class="card-body p-0" style="overflow-y: auto; height: calc(100% - 200px); background-color: #E4EBFF;">
                    <div class="order-items">
                        <div class="order-item py-3 px-3">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <div class="fw-bold">Yoyo</div>
                                </div>
                                <div class="col-4 text-center">
                                    <div>Rp 10.000</div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <button class="btn btn-sm btn-outline-secondary rounded" style="width: 30px; height: 30px; padding: 0;">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <span class="mx-2 fw-bold">2</span>
                                        <button class="btn btn-sm btn-outline-secondary rounded" style="width: 30px; height: 30px; padding: 0;">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order-item py-3 px-3">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <div class="fw-bold">Congklak</div>
                                </div>
                                <div class="col-4 text-center">
                                    <div>Rp 15.000</div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <button class="btn btn-sm btn-outline-secondary rounded" style="width: 30px; height: 30px; padding: 0;">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <span class="mx-2 fw-bold">1</span>
                                        <button class="btn btn-sm btn-outline-secondary rounded" style="width: 30px; height: 30px; padding: 0;">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order-item py-3 px-3">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <div class="fw-bold">Monopoli</div>
                                </div>
                                <div class="col-4 text-center">
                                    <div>Rp 20.000</div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <button class="btn btn-sm btn-outline-secondary rounded" style="width: 30px; height: 30px; padding: 0;">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <span class="mx-2 fw-bold">3</span>
                                        <button class="btn btn-sm btn-outline-secondary rounded" style="width: 30px; height: 30px; padding: 0;">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer p-3" style="border-radius:0 0 15px 15px; border-top: 1px solid #dee2e6; background-color: #E4EBFF;">
                    <div class="row mb-2">
                        <div class="col-4">Diskon</div>
                        <div class="col-8 text-end">Rp 0</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Total Harga</strong></div>
                        <div class="col-8 text-end"><strong>Rp 85.000</strong></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">Bayar</div>
                        <div class="col-8 text-end">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control text-end" value="100000">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">Kembalian</div>
                        <div class="col-8 text-end">Rp 15.000</div>
                    </div>
                    <button class="btn w-100 text-white" style="background-color: #1F9B30;">Bayar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

@endsection
