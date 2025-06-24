<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang - {{ $periode }}</title>    <style>
        @page {
            margin: 1cm;
            size: A4;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            margin: 1cm;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header .subtitle {
            font-size: 14px;
            margin-bottom: 3px;
        }

        .header .period {
            font-size: 12px;
            margin-bottom: 10px;
        }

        .info-section {
            margin-bottom: 15px;
        }

        .info-row {
            margin-bottom: 3px;
            display: block;
        }

        .info-label {
            font-weight: bold;
            display: inline;
        }

        .info-value {
            display: inline;
        }        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .main-table th {
            background-color: #000;
            color: white;
            padding: 10px 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #000;
            font-size: 12px;
        }

        .main-table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #000;
            vertical-align: middle;
        }

        .main-table tbody tr:nth-child(even) {
            background-color: #fff;
        }

        .main-table tbody tr:nth-child(odd) {
            background-color: #fff;
        }

        .tanggal-col {
            width: 20%;
            font-weight: normal;
        }

        .produk-col {
            width: 40%;
            text-align: left;
            font-weight: normal;
        }

        .jenis-col {
            width: 25%;
        }

        .jumlah-col {
            width: 15%;
            font-weight: normal;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            padding: 20px;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 10px;
        }

        .summary-section {
            margin-top: 20px;
        }

        .summary-row {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .summary-label {
            display: inline;
        }

        .summary-value {
            display: inline;
        }        /* Print optimizations */
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            
            .main-table th {
                background-color: #000 !important;
                color: white !important;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>OKE TOYS</h1>
        <div class="subtitle">Laporan Transaksi Barang</div>
        <div class="period">Periode: {{ $periode }}</div>
    </div>    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Jenis Transaksi:</span>
            <span class="info-value">
                @if($jenis === 'masuk')
                    Transaksi Masuk
                @elseif($jenis === 'keluar')
                    Transaksi Keluar
                @else
                    Semua Transaksi
                @endif
            </span>
        </div>
        @if($cari)
        <div class="info-row">
            <span class="info-label">Pencarian:</span>
            <span class="info-value">{{ $cari }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="info-label">Tanggal Cetak:</span>
            <span class="info-value">{{ $tanggalCetak }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Data:</span>
            <span class="info-value">{{ $totalData }} transaksi</span>
        </div>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th class="tanggal-col">Tanggal</th>
                <th class="produk-col">Nama Produk</th>
                <th class="jenis-col">Jenis Transaksi</th>
                <th class="jumlah-col">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporanBarang as $item)
            <tr>
                <td class="tanggal-col">{{ $item->tanggal_formatted }}</td>
                <td class="produk-col">{{ $item->nama_produk }}</td>                <td class="jenis-col">
                    @if($item->jenis_transaksi == 'Masuk')
                        Masuk
                    @else
                        Keluar
                    @endif
                </td>
                <td class="jumlah-col">{{ $item->jumlah }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="no-data">Tidak ada data laporan barang</td>
            </tr>
            @endforelse
        </tbody>
    </table>    @if($laporanBarang->isNotEmpty())
    <div class="summary-section">
        <div class="summary-row">
            <span class="summary-label">Total Transaksi Masuk:</span>
            <span class="summary-value">{{ $totalMasuk }} item</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Total Transaksi Keluar:</span>
            <span class="summary-value">{{ $totalKeluar }} item</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Total Semua Transaksi:</span>
            <span class="summary-value">{{ $totalSemua }} item</span>
        </div>
    </div>
    @endif

</body>
</html>
