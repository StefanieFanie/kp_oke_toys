@extends('layout')
@section('title', 'Oke Toys')

@section('content')
<style>
    .btn {
        padding: 0px 8px 3px 8px;
    }

    
    .nama-kategori {
        font-size: 1.25rem;
        font-weight: 500;
        background-color: #f8f9fa; 
    }

    .btn-tambah-kategori {
        background-color: #3B4B7A;
        color: white;
        font-weight: 600;
        bottom: 30px;
        right: 30px;
        position: fixed;
        padding: 10px 15px 10px 15px;
        box-shadow: 5px 5px 10px rgb(112, 112, 112);
        border-radius: 8px;
    }
    .btn-tambah-kategori:hover {
        background-color: #2C3245;
        color: white;
    }

    .btn-tambah-kateg:hover{
        background-color: #2C3245;
        color: white;
    }
    
    .table-custom {
        border-collapse: separate;
        border-spacing: 0 15px;
    }
    
    .table-custom tr {
        margin: 10px;
        border-radius: 15px !important;
    }
    
    
    .table-custom td {  
        background-color: #E4EBFF;
        border-radius: 15px;
        
    }

    .action-cell {
        border: none !important;
        background-color: transparent !important;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        font-style: italic;
        color: #6c757d;
    }
    
    @media (max-width: 767px) {
        .nama-kategori {
            font-size: 1rem;
            padding: 10px !important;
        }
        
        .btn-aksi {
            padding: 0px 6px 2px 6px;
        }
        
        .btn-aksi svg {
            width: 14px;
            height: 14px;
        }
        
        .action-cell {
            width: 80px !important;
        }
        
        .btn-tambah-kategori {
            font-size: 0.9rem;
            padding: 8px 12px;
            bottom: 20px;
            right: 20px;
        }
    }
</style>
<div>
    <h3 class="mb-4"><b>Oke Toys - Kategori</b></h3>
    
    <!-- Success and error messages will be shown with SweetAlert -->
    
    <div class="">
        <table class="table table-custom">
            <tbody>
                @forelse($kategori as $item)
                <tr>
                    <td class="nama-kategori">{{ $item->nama_kategori }}</td>
                    <td class="action-cell" style="width: 100px; text-align: center;">
                        <a class="btn btn-warning btn-aksi" role="button" href="{{ route('edit-kategori', $item->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        </a>
                        <form id="soft-delete-kategori-form-{{ $item->id }}" action="{{ route('hapus-kategori', $item->id) }}" method="POST" style="display: none">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button class="btn btn-danger btn-aksi" role="button" onclick="konfirmasiHapusKategori({{ $item->id }}, '{{ $item->nama_kategori }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="no-data">Belum ada data kategori</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <a  href="{{ route('tambah-kategori') }}" class="btn btn-tambah-kategori">+ Tambah Kategori</a>
</div>

<script>
    function konfirmasiHapusKategori(id, namaKategori) {
        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus kategori ini?',
            text: 'Kategori: ' + namaKategori,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if(result.isConfirmed) {
                document.getElementById('soft-delete-kategori-form-' + id).submit();
            }
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>

@endsection
