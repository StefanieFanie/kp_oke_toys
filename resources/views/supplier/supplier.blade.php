@extends('layout')
@section('title', 'Oke Toys')
<style>
    th, td {
        background-color: #E4EBFF !important;
        text-align: center !important;
        color: #2C3245 !important;
    }

    .nama-supplier {
        max-width: 250px;
        text-align: left !important;
    }

    .btn {
        padding: 0px 8px 3px 8px;
    }

    .btn-tambah-supplier {
        background-color: #3B4B7A !important;
        color: white !important;
        font-weight: 600;
        bottom: 30px;
        right: 30px;
        position: fixed;
        padding: 10px 15px 10px 15px;
        box-shadow: 5px 5px 10px rgb(112, 112, 112);
    }

    .btn-tambah-supplier:hover{
        background-color: #2C3245 !important;
        color: white;
    }
</style>
@section('content')
<div>
    <h3 class="mb-4"><b>Oke Toys - Supplier</b></h3>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered border-secondary table-sm">
            <thead>
                <tr>
                    <th scope="col">Nama Supplier</th>
                    <th scope="col">Nomor Telepon</th>
                    <th scope="col">Email</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Tanggal Terdaftar</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($supplier as $item)
                    <tr>
                        <td class="nama-supplier">{{ $item->nama_supplier }}</td>
                        <td>{{ $item->nomor_telepon }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                        <td>
                            <a class="btn btn-warning" role="button" href="{{ route('edit-supplier', $item->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                            <form id="soft-delete-supplier-form-{{ $item->id }}" action="{{ route('hapus-supplier', $item->id) }}" method="POST" style="display: none">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button class="btn btn-danger" role="button" onclick="konfirmasiHapusSupplier({{ $item->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Data supplier kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <a href="{{ route('tambah-supplier') }}" class="btn btn-tambah-supplier">+ Tambah Supplier</a>
</div>
<script>
    function konfirmasiHapusSupplier(id) {
        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus supplier ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if(result.isConfirmed) {
                document.getElementById('soft-delete-supplier-form-' + id).submit();
            }
        });
    }
</script>
@endsection
