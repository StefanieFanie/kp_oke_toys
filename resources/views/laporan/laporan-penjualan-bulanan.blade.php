<style>
    table, th, td {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
    }
</style>
<h1 style="text-align: center;">Laporan Penjualan Oke Toys</h1>
<h3 style="text-align: center;">Bulan {{ $bulan }} Tahun {{ $tahun }}</h3>
<br>
<div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col" style="width: 10%;">ID Penjualan</th>
                <th scope="col">Tanggal Penjualan</th>
                <th scope="col">Jenis Penjualan</th>
                <th scope="col">Jenis Pelanggan</th>
                <th scope="col">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php
                $omset = 0;
                $total_penjualan_offline = 0;
                $total_penjualan_online = 0;
            @endphp
            @forelse ($penjualan as $item)
                @php
                    $total = 0;
                    foreach ($item->produkPenjualan as $produk) {
                        $total += $produk->harga_jual * $produk->jumlah;
                    };
                    $omset += $total;
                @endphp
                @if ($item->jenis_penjualan == "offline")
                    @php
                        $total_penjualan_offline += $total;
                    @endphp
                @else
                    @php
                        $total_penjualan_online += $total;
                    @endphp
                @endif
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->jenis_penjualan }}</td>
                    <td>
                        @if ($item->diskon == 0)
                            Reseller
                        @else
                            Non Reseller
                        @endif
                    </td>
                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @empty
            @endforelse
            <tr>
                <td colspan="4">
                    <b>Total Omset</b>
                </td>
                <td>
                    Rp {{ number_format($omset, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>
    <h3>Rekapitulasi Penjualan</h3>
    <table class="table table-bordered">
        <tr>
            <td>Penjualan Offline</td>
            <td>Rp {{ number_format($total_penjualan_offline, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Penjualan Online</td>
            <td>Rp {{ number_format($total_penjualan_online, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Pendapatan Bersih Penjualan Offline</td>
            <td>Rp {{ number_format($laba_bersih_offline, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Pendapatan Bersih Penjualan Online</td>
            <td>Rp {{ number_format($laba_bersih_online, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Pendapatan Bersih</td>
            <td>Rp {{ number_format(($laba_bersih_offline + $laba_bersih_online), 0, ',', '.') }}</td>
        </tr>
    </table>
</div>
