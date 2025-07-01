<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Print Struk - {{ str_pad($penjualan->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap');

        @media print {
            @page {
                margin: 0;
            }
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                margin: 0 !important;
                padding: 2mm !important;
                font-size: 10px !important;
            }
            #strukContent {
                margin: 0 !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
        }

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.4;
            margin: 0;
            padding: 5mm;
            background: white;
            color: #000;
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        #strukContent {
            width: 100%;
            margin: 0 auto;
            box-sizing: border-box;
            color: #000;
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }

        .store-name {
            font-size: 18px;
            font-weight: 900;
            margin-bottom: 3px;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Roboto', sans-serif;
        }

        .store-info {
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 2px;
            color: #000;
            line-height: 1.2;
            font-family: 'Roboto', sans-serif;
        }

        .transaction-info {
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.3;
            color: #000;
            font-family: 'Roboto', sans-serif;
        }

        .transaction-info div {
            margin-bottom: 2px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #000;
            font-family: 'Roboto', sans-serif;
        }

        .items-table th {
            border-bottom: 1px dashed #000;
            font-weight: 700;
            padding: 4px 2px;
            font-size: 12px;
            text-align: left;
            color: #000;
            font-family: 'Roboto', sans-serif;
        }

        .items-table td {
            padding: 3px 2px;
            vertical-align: top;
            font-size: 12px;
            font-weight: 500;
            color: #000;
            word-wrap: break-word;
            font-family: 'Roboto', sans-serif;
        }

        .item-name {
            width: 40%;
            text-align: left;
        }

        .item-qty {
            width: 15%;
            text-align: center;
        }

        .item-price {
            width: 22%;
            text-align: right;
        }

        .item-total {
            width: 23%;
            text-align: right;
        }

        .summary {
            border-top: 1px dashed #000;
            padding-top: 5px;
            margin-top: 5px;
            font-size: 12px;
            font-weight: 500;
            color: #000;
            font-family: 'Roboto', sans-serif;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
            font-weight: 500;
            color: #000;
            font-family: 'Roboto', sans-serif;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 14px;
            font-weight: 700;
            border-top: 1px solid #000;
            padding-top: 3px;
            color: #000;
            font-family: 'Roboto', sans-serif;
        }

        .footer {
            text-align: center;
            margin-top: 8px;
            border-top: 1px dashed #000;
            padding-top: 5px;
            font-size: 11px;
            font-weight: 500;
            color: #000;
            line-height: 1.3;
            font-family: 'Roboto', sans-serif;
        }

        .thank-you {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 3px;
            color: #000;
            font-family: 'Roboto', sans-serif;
        }

        * {
            color: #000 !important;
            background: white !important;
            font-family: 'Roboto', sans-serif !important;
        }

        body, div, span, table, th, td, p {
            color: #000 !important;
            font-family: 'Roboto', sans-serif !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    </style>
</head>
<body>
    <div id="strukContent">
        <div class="header">
            <div class="store-name">OKE TOYS</div>
            <div class="store-info">Jl. Urip Sumoharjo No.30, 2 Ilir, Kec. Ilir</div>
            <div class="store-info">Tim. II, Kota Palembang, Sumatera Selatan</div>
            <div class="store-info">30118</div>
            <div class="store-info">Telp: (+62) 82280319910</div>
        </div>
        <div class="transaction-info">
            <div>No. Transaksi: {{ str_pad($penjualan->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div>Tanggal: {{ \Carbon\Carbon::parse($penjualan->created_at)->format('d/m/Y H:i:s') }}</div>
            <div>Kasir: {{ $penjualan->user->name ?? 'Unknown' }}</div>
            <div>Jenis: {{ ucfirst($penjualan->jenis_penjualan) }}</div>
        </div>
        <table class="items-table">
            <thead>
                <tr>
                    <th class="item-name">Item</th>
                    <th class="item-qty">Qty</th>
                    <th class="item-price">Harga</th>
                    <th class="item-total">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan->produkPenjualan as $item)
                <tr>
                    <td class="item-name">{{ $item->produk->nama_produk }}</td>
                    <td class="item-qty">{{ $item->jumlah }}</td>
                    <td class="item-price">{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                    <td class="item-total">{{ number_format($item->harga_jual * $item->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($penjualan->total + $penjualan->diskon, 0, ',', '.') }}</span>
            </div>
            @if($penjualan->diskon > 0)
            <div class="summary-row">
                <span>Diskon:</span>
                <span>- Rp {{ number_format($penjualan->diskon, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="total-row">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="footer">
            <div class="thank-you">TERIMA KASIH</div>
            <div>Barang yang sudah dibeli</div>
            <div>tidak dapat dikembalikan</div>
            <div style="margin-top: 5px;">{{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</div>
        </div>
    </div>
    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 1000);
        });
        window.addEventListener('afterprint', function() {
            setTimeout(function() {
                window.close();
            }, 500);
        });
        window.addEventListener('beforeunload', function() {
            window.close();
        });
    </script>
</body>
</html>
