@extends('layout')
@section('title', 'Oke Toys')
@section('content')
    <h3 class="mb-4">
        <b>Oke Toys - Rincian Penjualan</b>
    </h3>
    <p>ID Penjualan: {{ $penjualan->id }}</p>
    <p>Tanggal Penjualan: {{ $penjualan->tanggal }}</p>
    <p>Jenis Penjualan: {{ $penjualan->jenis_penjualan }}</p>
    <p>Diinput Oleh: {{ $penjualan->user->name }}</p>
    <table class="table table-bordered border-secondary table-sm" style="text-align: center;">
        <thead>
            <tr>
                <th scope="col" class="th-color">Nama Produk</th>
                <th scope="col">Harga Modal</th>
                <th scope="col">Harga Jual</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach ($penjualan_produk as $item)
                <tr>
                    <td>{{ $item->produk->nama_produk }}</td>
                    <td>Rp {{ number_format($item->harga_modal, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->harga_jual * $item->jumlah, 0, ',', '.') }}</td>
                </tr>
                @php
                    $total += ($item->harga_jual * $item->jumlah);
                @endphp
            @endforeach
            <tr>
                <td colspan="4"><b>Diskon Reseller</b></td>
                <td>Rp {{ number_format($penjualan->diskon, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="4"><b>Total Penjualan</b></td>
                <td>Rp {{ number_format(($total-$penjualan->diskon), 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
@endsection
