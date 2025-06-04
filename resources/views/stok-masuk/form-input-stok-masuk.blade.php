@extends('layout')
@section('title', 'Oke Toys')
<style>
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

    .readonly {
        background-color: transparent;
        text-align: center;
        border: none;
        width: 100px;
    }

    .edit-jumlah {
        background-color: white;
        text-align: center;
        border: 1 px solid #2C3245;
        width: 100px;
    }
</style>
@section('content')
    <h3 class="mb-4"><b>Oke Toys - Stok Masuk</b></h3>
    <h3 class="mb-4"><b>Formulir Input Stok Masuk</b></h3>
    <div id="halaman1">
        <form method="POST" action="{{ route('temp-tambah-stok-masuk') }}">
            @csrf
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Stok Masuk</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $temp_stok_masuk['tanggal'] ?? old('tanggal') }}" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="id_supplier" class="form-label">Supplier</label>
                <select class="form-select" id="id_supplier" name="id_supplier" required>
                    <option selected disabled value="">Pilih supplier</option>
                    @forelse ($supplier as $item)
                        <option value="{{ $item->id }}"
                        @if (isset($temp_stok_masuk['id_supplier']) && $temp_stok_masuk['id_supplier'] == $item->id)
                            selected
                        @elseif (old('id_supplier') == $item->id)
                            selected
                        @endif>
                            {{ $item->nama_supplier }}
                        </option>
                    @empty
                        <option selected disabled value="">Belum ada data supplier, tambahkan data supplier terlebih dahulu</option>
                    @endforelse
                </select>
            </div>
            <button type="submit" id="button_selanjutnya" onclick="halamanSelanjutnya()" class="btn btn1" style="float:right" disabled>Selanjutnya</button>
        </form>
    </div>
    <div id="halaman2" class="hidden">
        <form method="POST" action="{{ route('temp-tambah-stok-masuk-produk') }}">
            @csrf
            <label for="id_produk" class="form-label"><b>Pilih produk</b></label>
            <div style="display: flex; gap: 10px">
                <select id="select-produk" name="id_produk" placeholder="Pilih produk" autocomplete="off" style="width: 70%;">
                    @forelse ($produk as $item)
                        <option value={{ $item->id }}>{{ $item->nama_produk }}</option>
                    @empty
                        <option selected disabled value="">Belum ada data produk, tambahkan data produk terlebih dahulu</option>
                    @endforelse
                </select>
                <input type="number" class="form-control" id="jumlah" name="jumlah" autocomplete="off" style="width: 10%; height: 35px;" required>
                <button type="submit" class="btn btn1" style="float: right; width: 20%; margin-top: 0;">+ Tambah Stok Masuk</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered border-secondary table-sm">
                <thead>
                    <tr>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Sub Total</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($temp_stok_masuk_produk as $i => $item)
                        <tr>
                            <td class="nama-produk">{{ $item['nama_produk'] }}</td>
                            <td id="harga-{{ $item['id_produk'] }}">{{ $item['harga'] }}</td>
                            <td>
                                <input type="number" id="edit-jumlah-{{ $item['id_produk'] }}" name="edit_jumlah" value="{{ $item['jumlah'] }}" class="readonly" disabled>
                            </td>
                            <td id="sub_total-{{ $item['id_produk'] }}">{{ $item['sub_total'] }}</td>
                            <td>
                                <button id="button-edit-{{ $item['id_produk'] }}" class="btn btn-warning" role="button" onclick="edit({{ $item['id_produk'] }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </button>
                                <form method="POST" action="{{ route('temp-update-stok-masuk-produk') }}">
                                    @csrf
                                    <input type="hidden" name="id_produk" value="{{ $item['id_produk'] }}">
                                    <input type="hidden" id="hidden-jumlah-{{ $item['id_produk'] }}" name="jumlah" value="{{ $item['jumlah'] }}">
                                    <button type="submit" id="button-simpan-{{ $item['id_produk'] }}" class="btn btn-success" role="button" onclick="simpanPerubahan({{ $item['id_produk'] }})" style="display: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                        </svg>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('temp-hapus-stok-masuk-produk') }}" style="display: inline">
                                    @csrf
                                    <input type="hidden" name="index" value="{{ $i }}">
                                    <button class="btn btn-danger" role="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
        <p class="mb-4"><b>Total Harga: Rp {{ number_format(session('total')) }}</b></p>
        <form method="POST" action="{{ route('simpan-stok-masuk') }}">
            @csrf
            <div class="mb-3">
                <label for="catatan-pembayaran" class="form-label">Catatan Pembayaran</label>
                <select class="form-select" id="catatan_pembayaran" name="catatan_pembayaran" required>
                    <option selected disabled value="">Pilih catatan pembayaran</option>
                    <option value="Cash">Cash</option>
                    <option value="Bon">Bon</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal-jatuh-tempo" class="form-label">Tanggal Jatuh Tempo</label>
                <input type="date" class="form-control" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" autocomplete="off" required>
            </div>
            <button type="submit" class="btn btn1" style="float:right">Selesai</button>
        </form>
    </div>
    <script>
        const input_tgl_stok_masuk = document.getElementById('tanggal');
        const pilih_supplier = document.getElementById('id_supplier');
        const button_selanjutnya = document.getElementById('button_selanjutnya');

        function cekIsiInput() {
            if (input_tgl_stok_masuk.value !== "" && pilih_supplier.value !== "") {
                button_selanjutnya.disabled = false;
            } else {
                button_selanjutnya.disabled = true;
            }
        }

        input_tgl_stok_masuk.addEventListener('input', cekIsiInput);
        pilih_supplier.addEventListener('input', cekIsiInput);

        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('select-produk')) {
                new TomSelect("#select-produk");
            }
        });

        const done_page_1 = sessionStorage.getItem('donePage1');

        if (done_page_1 === 'true') {
            document.getElementById('halaman1').style.display = 'none';
            document.getElementById('halaman2').style.display = 'block';
        } else {
            document.getElementById('halaman1').style.display = 'block';
            document.getElementById('halaman2').style.display = 'none';
        }

        function halamanSelanjutnya() {
            sessionStorage.setItem('donePage1', 'true');
            document.getElementById('halaman1').style.display = 'none';
            document.getElementById('halaman2').style.display = 'block';
        }

        function edit(id_produk) {
            const input = document.getElementById(`edit-jumlah-${id_produk}`);
            const edit_button = document.getElementById(`button-edit-${id_produk}`);
            const simpan_button = document.getElementById(`button-simpan-${id_produk}`);
            input.removeAttribute('disabled');
            input.classList.remove('readonly');
            input.classList.add('edit-jumlah');
            input.focus();
            simpan_button.style.display = 'inline-block';
            edit_button.style.display = 'none';
        }

        function simpanPerubahan(id_produk) {
            const input = document.getElementById(`edit-jumlah-${id_produk}`);
            const edit_button = document.getElementById(`button-edit-${id_produk}`);
            const simpan_button = document.getElementById(`button-simpan-${id_produk}`);
            input.setAttribute('disabled', true);
            input.classList.remove('edit-jumlah');
            input.classList.add('readonly');
            simpan_button.style.display = 'none';
            edit_button.style.display = 'inline-block';
            document.getElementById(`hidden-jumlah-${id_produk}`).value = input.value;
        }
    </script>
@endsection
