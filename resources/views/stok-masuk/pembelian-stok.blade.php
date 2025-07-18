@extends('layout')
@section('title', 'Oke Toys')
<style>
    th, td {
        background-color: #E4EBFF !important;
        text-align: center !important;
        color: #2C3245 !important;
    }

    .belum-lunas {
        background-color: #ffcfcf !important;
    }

    .btn {
        padding: 5px !important;
        background-color: #A1C6FF !important;
    }

    .btn-tambah-stok-masuk {
        background-color: #3B4B7A !important;
        color: white !important;
        font-weight: 600;
        bottom: 30px;
        right: 30px;
        position: fixed;
        padding: 10px 15px 10px 15px !important;
        box-shadow: 5px 5px 10px rgb(112, 112, 112);
    }

    .btn-tambah-stok-masuk:hover{
        background-color: #2C3245 !important;
        color: white;
    }
</style>
@section('content')
    <h3 class="mb-4"><b>Oke Toys - Pembelian Stok</b></h3>
    <div class="table-responsive">
        <table class="table table-bordered border-secondary table-sm">
            <thead>
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">Total</th>
                    <th scope="col">Catatan</th>
                    <th scope="col">Tanggal Jatuh Tempo</th>
                    <th scope="col">Selengkapnya</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stok_masuk as $item)
                    <tr>
                        @php
                            $total = 0;
                            foreach ($item->stokMasukProduk as $produkMasuk) {
                                $total += $produkMasuk->jumlah * $produkMasuk->harga;
                            }
                        @endphp
                        <td class="{{ $item->status === 0 ? 'belum-lunas' : '' }}">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td class="{{ $item->status === 0 ? 'belum-lunas' : '' }}">{{ $item->supplier->nama_supplier }}</td>
                        <td class="{{ $item->status === 0 ? 'belum-lunas' : '' }}">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        <td class="{{ $item->status === 0 ? 'belum-lunas' : '' }}">{{ $item->catatan }}</td>
                        <td class="{{ $item->status === 0 ? 'belum-lunas' : '' }}">{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') }}</td>
                        <td class="{{ $item->status === 0 ? 'belum-lunas' : '' }}">
                            <a class="btn" role="button" href="{{ route('rincian-stok-masuk', $item->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada stok masuk</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $stok_masuk->links('pagination::bootstrap-5') }}
    </div>
    <a href="{{ route('form-input-stok-masuk') }}" class="btn btn-tambah-stok-masuk">+ Tambah Stok Masuk</a>
@endsection
