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

    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
    }

    .toast {
        min-width: 250px;
        background-color: #fff;
        color: #333;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        border-left: 5px solid;
        opacity: 0;
        transform: translateX(50px);
        transition: all 0.3s ease-in-out;
    }

    .toast.show {
        opacity: 1;
        transform: translateX(0);
    }

    .toast.error {
        border-left-color: #f44336;
    }

    .toast.success {
        border-left-color: #4CAF50;
    }

    .toast-icon {
        margin-right: 10px;
        font-size: 20px;
    }

    .toast-message {
        flex-grow: 1;
    }

    .toast-close {
        cursor: pointer;
        font-size: 18px;
        color: #aaa;
    }

    .toast-close:hover {
        color: #333;
    }

    @media (max-width: 768px) {
        .grid-kiri {
            margin-bottom: 60px;
        }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .spin {
        animation: spin 1s linear infinite;
    }

    .custom-spinner {
        width: 16px;
        height: 16px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #333;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: inline-block;
    }
</style>

<div class="toast-container"></div>

<div class="d-flex flex-column " style="height: calc(100% - 64px);">
    <div class="row align-items-center">
        <div class="col-md-4">
            <h3 class=" text-dark"><b>Oke Toys - Kasir</b></h3>
        </div>
        <div class="col-md-4 d-flex justify-content-end ">
            <div class="d-flex align-items-center me-3">
                <span class="me-2"><b>Diskon reseller</b></span>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="toggle-diskon-reseller" name="toggle-diskon-reseller" style="width: 48px; height: 24px;">
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
                                 <form method="POST" action="{{ route('simpan-penjualan', [ 'id_produk' => $item->id]) }}" data-harga-jual="{{ $item->harga_jual }}" data-stok="{{ $item->stok }}">
                                    @csrf
                                    <tr>
                                        <td class="align-middle text-center">
                                            <img src="{{ asset('storage/' . $item->foto_produk) }}" width="50px" height="50px">
                                        </td>
                                        <td class="align-middle text-center">{{ $item->nama_produk }}</td>
                                        <td class="align-middle text-center">{{ $item->stok }}</td>
                                        <td class="align-middle text-center">Rp {{ $item->harga_jual }}</td>
                                        <td class="align-middle text-center" style="width: 100px;">
                                         <input type="number" name="jumlah_produk" class="form-control-sm text-center" value="0" min="0" style="width: 60px; margin: 0 auto;">
                                        </td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-md" type="submit" style="background-color: #A1C6FF; border:1px solid #8EABFF;box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);">
                                                <i class="bi bi-basket"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </form>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 ps-md-2" style="height: calc(100vh - 168px);">
            <div class="card d-flex flex-column" style="border-radius:16px; border: 1px solid #8EABFF; margin-top: -41px; height: calc(100vh - 66px); box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #3B4B7A; padding: 12px 15px; border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0">Daftar Pesanan</h5>
                    <form action="{{ route('hapus-semua-produk') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger" style="box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>

<div class="card-body p-0 flex-grow-1 overflow-auto" style="background-color: #E4EBFF;">
    <div class="order-items">
        @foreach (session('produk', []) as $id_produk => $item)
        @php $product = \App\Models\produk::find($item['id_produk']); @endphp
        <div class="order-item py-3 px-3">
            <div class="row align-items-center">
                <div class="col-3">
                    <div class="fw-bold">@if($product)
                        {{ $product->nama_produk }}
                    @endif</div>
                </div>
                <div class="col-3 text-center">
                    <div>{{ isset($item['harga_jual']) ? 'Rp ' . number_format($item['harga_jual'], 0, '.', '.') : '' }}</div>
                </div>
                <div class="col-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <form action="{{ route('kurang-jumlah', ['id_produk' => $item['id_produk']]) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary rounded" style="width: 30px; height: 30px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-dash"></i>
                            </button>
                        </form>
                        <span class="mx-2 fw-bold">{{ $item['jumlah_produk'] }}</span>
                        <form action="{{ route('tambah-jumlah', ['id_produk' => $item['id_produk']]) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary rounded" style="width: 30px; height: 30px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-3 text-end">
                    <div>
                        {{ (isset($item['harga_jual']) && isset($item['jumlah_produk'])) ? 'Rp ' . number_format($item['harga_jual'] * $item['jumlah_produk'], 0, '.', '.') : '' }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

                <div class="card-footer p-3 mt-auto" style="border-radius:0 0 15px 15px; border-top: 1px solid #dee2e6; background-color: #E4EBFF;">
                    <form id="formPembayaran" action="{{ route('pembayaran') }}" method="POST">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-4">Diskon</div>
                            <div class="col-8 text-end" id="diskonValue">Rp 0</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Total Harga</strong></div>
                            <div class="col-8 text-end"><strong id="totalHarga">
                                Rp {{ number_format(session('produk') ? array_sum(array_map(function($item) {
                                    return $item['harga_jual'] * $item['jumlah_produk'];
                                }, session('produk'))) : 0, 0, '.', '.') }}
                            </strong></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">Bayar</div>
                            <div class="col-8 text-end">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" id="inputBayar" name="bayar_display" class="form-control text-end" value="" placeholder="0" onkeyup="hitungKembalian()" onchange="hitungKembalian()">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">Kembalian</div>
                            <div class="col-8 text-end" id="kembalianValue">Rp 0</div>
                        </div>
                        
                        <!-- Hidden fields untuk data yang akan dikirim -->
                        <input type="hidden" id="hiddenTotal" name="total" value="0">
                        <input type="hidden" id="hiddenBayar" name="bayar" value="0">
                        <input type="hidden" id="hiddenJenisPenjualan" name="jenis_penjualan" value="offline">
                        <input type="hidden" id="hiddenDiskon" name="diskon" value="0">
                        
                        <button type="button" class="btn w-100 text-white" id="btnBayar" style="background-color: #1F9B30;" onclick="konfirmasiPembayaran()">Bayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let diskonResellerAktif = false;

    document.addEventListener('DOMContentLoaded', function() {
        console.log('Diskon value dari controller: ', {{ $diskon_reseller ?? 0 }});

        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif

        @if(session('update_status'))
            showToast('{{ session('update_message') }}', '{{ session('update_status') }}');
        @endif

        loadDiskonState();
        hitungTotal();
        hitungKembalian();

        const pesananOnlineToggle = document.getElementById('pesananOnline');
        if (pesananOnlineToggle) {
            pesananOnlineToggle.addEventListener('change', function() {
                hitungKembalian();
            });
        }

        const diskonResellerToggle = document.getElementById('toggle-diskon-reseller');
        if (diskonResellerToggle) {
            diskonResellerToggle.addEventListener('change', function() {
                diskonResellerAktif = this.checked;
                saveDiskonState();
                hitungTotal();
                hitungKembalian();

                if (this.checked) {
                    showToast('Diskon reseller diaktifkan', 'success');
                } else {
                    showToast('Diskon reseller dinonaktifkan', 'success');
                }
            });
        }

        const inputBayar = document.getElementById('inputBayar');
        inputBayar.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            if (value !== '') {
                value = parseInt(value, 10).toLocaleString('id-ID');
            }
            this.value = value;
        });
    });


    function loadDiskonState() {
        const saved = localStorage.getItem('diskon_reseller_aktif');
        if (saved !== null) {
            diskonResellerAktif = saved === 'true';
            document.getElementById('toggle-diskon-reseller').checked = diskonResellerAktif;
        }
    }

    function saveDiskonState() {
        localStorage.setItem('diskon_reseller_aktif', diskonResellerAktif.toString());
    }

    function formatRupiah(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function hitungTotal() {
        let totalHarga = 0;
        const orderItems = document.querySelectorAll('.order-item');
        
        orderItems.forEach(item => {
            const priceElement = item.querySelector('.col-3.text-end div');
            
            if (priceElement) {
                const priceText = priceElement.textContent.replace(/[^\d]/g, '');
                const price = parseInt(priceText) || 0;
                totalHarga += price;
            }
        });
        
        let diskon = 0;
        if (diskonResellerAktif) {
            let persentaseDiskon = {{ $diskon_reseller ?? 0 }};
            diskon = Math.round(totalHarga * (persentaseDiskon / 100));
            console.log('Diskon aktif! Total: ', totalHarga,
            ', diskon (%): ', persentaseDiskon, ', diskon (Rp): ', diskon);
        }

        document.getElementById('diskonValue').textContent = 'Rp ' + diskon.toLocaleString('id-ID');
        document.getElementById('totalHarga').textContent = 'Rp ' + (totalHarga - diskon).toLocaleString('id-ID');

        return totalHarga - diskon;
    }

    function hitungKembalian() {
        const total = hitungTotal();
        let bayar = document.getElementById('inputBayar').value.replace(/\D/g, '') || 0;
        bayar = parseInt(bayar, 10);

        const kembalian = bayar - total;

        if (kembalian >= 0) {
            document.getElementById('kembalianValue').textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
        } else {
            document.getElementById('kembalianValue').textContent = 'Rp 0';
        }

        document.getElementById('hiddenTotal').value = total;
        document.getElementById('hiddenBayar').value = bayar;
        
        const pesananOnline = document.getElementById('pesananOnline').checked;
        document.getElementById('hiddenJenisPenjualan').value = pesananOnline ? 'online' : 'offline';
        
        let diskon = 0;
        if (diskonResellerAktif) {
            let persentaseDiskon = {{ $diskon_reseller ?? 0 }};
            diskon = Math.round(total * (persentaseDiskon / 100));
        }
        document.getElementById('hiddenDiskon').value = diskon;

        const btnBayar = document.getElementById('btnBayar');
        if (bayar >= total && total > 0) {
            btnBayar.disabled = false;
            btnBayar.style.opacity = 1;
        } else {
            btnBayar.disabled = true;
            btnBayar.style.opacity = 0.5;
        }
    }

    function showToast(message, type = 'error') {
        const toastContainer = document.querySelector('.toast-container');

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;

        let iconClass = type === 'error' ? 'bi-exclamation-circle' : 'bi-check-circle';

        toast.innerHTML = `
            <div class="toast-icon">
                <i class="bi ${iconClass}"></i>
            </div>
            <div class="toast-message">${message}</div>
            <div class="toast-close" onclick="closeToast(this.parentElement)">
                <i class="bi bi-x"></i>
            </div>
        `;

        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        setTimeout(() => {
            closeToast(toast);
        }, 3000);
    }

    function closeToast(toast) {
        toast.classList.remove('show');
        setTimeout(() => {
            if (toast.parentElement) {
                toast.parentElement.removeChild(toast);
            }
        }, 300);
    }

    function konfirmasiPembayaran() {
        const total = hitungTotal();
        let bayar = document.getElementById('inputBayar').value.replace(/\D/g, '') || 0;
        bayar = parseInt(bayar, 10);

        if (total <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Tidak ada produk di keranjang',
                confirmButtonColor: '#3B4B7A'
            });
            return;
        }

        if (bayar < total) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Jumlah bayar kurang dari total harga',
                confirmButtonColor: '#3B4B7A'
            });
            return;
        }

        const kembalian = bayar - total;
        const pesananOnline = document.getElementById('pesananOnline').checked;
        const jenisPenjualan = pesananOnline ? 'Online' : 'Offline';

        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            html: `
                <div style="text-align: left; margin: 20px 0;">
                    <p><strong>Jenis Penjualan:</strong> ${jenisPenjualan}</p>
                    <p><strong>Total Harga:</strong> Rp ${total.toLocaleString('id-ID')}</p>
                    <p><strong>Bayar:</strong> Rp ${bayar.toLocaleString('id-ID')}</p>
                    <p><strong>Kembalian:</strong> Rp ${kembalian.toLocaleString('id-ID')}</p>
                </div>
                <p>Apakah Anda yakin ingin melanjutkan pembayaran?</p>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1F9B30',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Bayar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                hitungKembalian();
                
                document.getElementById('formPembayaran').submit();
            }
        });
    }

    function tutupPopup() {
        Swal.close();
    }

    function resetKeranjang() {
        document.getElementById('inputBayar').value = '';
        document.getElementById('pesananOnline').checked = false;
        
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    }

    @if(session('show_payment_success'))
        document.addEventListener('DOMContentLoaded', function() {
            const total = {{ session('total', 0) }};
            const bayar = {{ session('bayar', 0) }};
            const kembalian = {{ session('kembalian', 0) }};
            const penjualanId = {{ session('penjualan_id', 0) }};

            Swal.fire({
                title: 'Pembayaran Berhasil!',
                html: `
                    <div style="text-align: center; margin: 20px 0;">
                        <i class="bi bi-check-circle-fill" style="font-size: 60px; color: #1F9B30;"></i>
                        <p style="margin-top: 15px; font-size: 16px;">Transaksi berhasil diproses</p>
                        <p><strong>ID Penjualan:</strong> ${penjualanId}</p>
                        <p><strong>Total:</strong> Rp ${total.toLocaleString('id-ID')}</p>
                        <p><strong>Kembalian:</strong> Rp ${kembalian.toLocaleString('id-ID')}</p>
                    </div>
                `,
                icon: null,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                footer: `
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <button type="button" class="btn btn-secondary" onclick="tutupPopup()">
                            <i class="bi bi-x-circle"></i> Tutup
                        </button>
                        <button type="button" class="btn btn-primary" onclick="">
                            <i class="bi bi-printer"></i> Cetak Struk
                        </button>
                    </div>
                `
            });

            resetKeranjang();
        });
    @endif
</script>
@endsection
