@extends('layout')
@section('title', 'Oke Toys')
<style>
    .btn {
    }

    .btn1 {
        background-color: #3B4B7A !important;
        color: white !important;
        font-weight: 600;
        padding: 5px 20px 5px 20px;
        box-shadow: 5px 5px 10px rgb(112, 112, 112);
        margin-top: 10px;
        margin-bottom: 30px;
    }

    .btn1:hover {
        background-color: #2C3245 !important;
        color: white !important;
    }

    .hidden {
        display: none;
    }

    .ts-wrapper {
        font-size: 16px;
    }

    .ts-dropdown .option {
        font-size: 16px;
    }

    .ts-wrapper.single .ts-control input::placeholder {
        font-size: 16px;
    }

    .ts-wrapper.single .ts-control .item {
        font-size: 16px;
    }

    th, td {
        background-color: #E4EBFF !important;
        text-align: center !important;
        color: #2C3245 !important;
    }

    .nama-produk {
        text-align: left !important;
    }
</style>
@section('content')
    <h3 class="mb-4"><b>Oke Toys - Stok Masuk</b></h3>
    <h3 class="mb-4"><b>Formulir Input Stok Masuk</b></h3>
    <form>
        <div id="halaman1">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Stok Masuk</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="id_supplier" class="form-label">Supplier</label>
                <select class="form-select" id="id_supplier" name="id_supplier" required>
                    <option selected disabled>Pilih supplier</option>
                    <option>Supplier 1</option>
                    <option>Supplier 2</option>
                    <option>Supplier 3</option>
                </select>
            </div>
            <button type="button" onclick="halamanSelanjutnya()" class="btn btn1" style="float:right">Selanjutnya</button>
        </div>
        <div id="halaman2" class="hidden">
            <label for="id_produk" class="form-label"><b>Pilih produk</b></label>
            <div style="display: flex; gap: 10px">
                <select id="select-produk" placeholder="Pilih produk" autocomplete="off" style="width: 70%;">
                    <option>Magnetic Drawing Board</option>
                    <option>5 in 1 Board Game</option>
                </select>
                <input type="number" class="form-control" id="jumlah" name="jumlah" autocomplete="off" style="width: 10%; height: 35px;" required>
                <button type="button" class="btn btn1" style="float: right; width: 20%; margin-top: 0;">+ Tambah Stok Masuk</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered border-secondary table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Total</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="nama-produk">Magnetic Drawing Board</td>
                            <td>Rp 21000</td>
                            <td>15</td>
                            <td>Rp 315.000</td>
                            <td>
                                <a class="btn btn-warning" role="button" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                                <button class="btn btn-danger" role="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="mb-4"><b>Total Harga: Rp ...</b></p>
            <div class="mb-3">
                <label for="catatan-pembayaran" class="form-label">Catatan Pembayaran</label>
                <select class="form-select" id="catatan_pembayaran" name="catatan_pembayaran" required>
                    <option selected disabled value="">Pilih catatan pembayaran</option>
                    <option value="cash">Cash</option>
                    <option value="bon">Bon</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal-jatuh-tempo" class="form-label">Tanggal Jatuh Tempo</label>
                <input type="date" class="form-control" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" autocomplete="off" required>
            </div>
            <button type="button" onclick="halamanSebelumnya()" class="btn btn1">Kembali</button>
            <button type="submit" class="btn btn1" style="float:right">Selesai</button>
        </div>
    </form>
    <script>
        function halamanSelanjutnya() {
            document.getElementById('halaman1').style.display = 'none';
            document.getElementById('halaman2').style.display = 'block';
            new TomSelect("#select-produk");
        }

        function halamanSebelumnya() {
            document.getElementById('halaman1').style.display = 'block';
            document.getElementById('halaman2').style.display = 'none';
        }
    </script>
@endsection
