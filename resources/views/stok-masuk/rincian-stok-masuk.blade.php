@extends('layout')
@section('title', 'Oke Toys')
<style>
    .button-selesai {
        background-color: #3B4B7A !important;
        color: white !important;
        font-weight: 600;
        bottom: 30px;
        right: 30px;
        position: fixed;
        padding: 10px 15px 10px 15px;
        box-shadow: 5px 5px 10px rgb(112, 112, 112);
    }
</style>
@section('content')
    <div>
        <h3 class="mb-4"><b>Oke Toys - Rincian Stok Masuk</b></h3>
        <p>ID Stok Masuk: {{ $stok_masuk->id }}</p>
        <p>Supplier: {{ $stok_masuk->supplier->nama_supplier }}</p>
        <p>Tanggal: {{ \Carbon\Carbon::parse($stok_masuk->tanggal)->format('d-m-Y') }}</p>
        <p>Catatan: {{ $stok_masuk->catatan }}</p>
        <form method="POST" action="{{ route('selesaikan-transaksi', $stok_masuk->id) }}">
            @csrf
            <div class="mb-3">
                <label for="tanggal-jatuh-tempo" class="form-label">Tanggal Jatuh Tempo</label>
                <input type="date" class="form-control" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo"
                autocomplete="off" required value="{{ $stok_masuk->tanggal_jatuh_tempo }}" readonly>
            </div>
            <div class="mb-3">
                <label for="tanggal-bayar" class="form-label">Tanggal Bayar</label>
                <input type="date" min="{{ date('Y-m-d', strtotime($stok_masuk->tanggal . '+1 day')) }}" class="form-control" id="tanggal_bayar" name="tanggal_bayar" autocomplete="off" required
                @if ($stok_masuk->status == 1)
                    value="{{ $stok_masuk->tanggal_bayar }}" readonly
                @endif>
            </div>
            <div class="mb-3">
                <label for="metode-pembayaran" class="form-label">Metode Pembayaran</label>
                <input type="text" class="form-control" id="metode_pembayaran" name="metode_pembayaran" autocomplete="off" required
                @if ($stok_masuk->status == 1)
                    value="{{ $stok_masuk->metode_pembayaran }}" readonly
                @endif>
            </div>
            <p>Rincian Produk Masuk</p>
            <div class="table-responsive">
                <table class="table table-bordered border-secondary table-sm">
                    <thead>
                        <tr style="text-align: center">
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stok_masuk_produk as $produk_masuk)
                            <tr>
                                <td>{{ $produk_masuk->produk->nama_produk }}</td>
                                <td>Rp {{ number_format($produk_masuk->produk->harga_modal, 0, ',', '.') }}</td>
                                <td>{{ $produk_masuk->jumlah }}</td>
                                <td>Rp {{ number_format($produk_masuk->sub_total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <h5>Total: Rp {{ number_format($stok_masuk->total, 0, ',', '.') }}</h5>
            <br>
            @if ($stok_masuk->status == 0)
                <button type="submit" class="btn button-selesai" id="button_selesai" disabled>Selesaikan dan Simpan</a>
            @endif
        </form>
    </div>
    <script>
        const input_metode_pembayaran = document.getElementById('metode_pembayaran');
        const input_tanggal_bayar = document.getElementById('tanggal_bayar');
        const button_selesai = document.getElementById('button_selesai');

        function cekIsiInput() {
            if (input_metode_pembayaran.value !== "" && input_tanggal_bayar.value !== "") {
                button_selesai.disabled = false;
            } else {
                button_selesai.disabled = true;
            }
        }

        input_metode_pembayaran.addEventListener('input', cekIsiInput);
        input_tanggal_bayar.addEventListener('input', cekIsiInput);
    </script>
@endsection
