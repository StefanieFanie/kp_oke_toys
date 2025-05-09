@extends('layout')
@section('title', 'Oke Toys - Users')
<style>

    th, td {
        background-color: #E4EBFF !important;
        text-align: center !important;
        color: #2C3245 !important;
    }

    .nama-user {
        max-width: 250px;
        text-align: left !important;
    }

    .btn {
        padding: 0px 8px 3px 8px;
    }

    .btn-tambah-user {
        background-color: #3B4B7A !important;
        color: white !important;
        font-weight: 600;
        bottom: 30px;
        right: 30px;
        position: fixed;
        padding: 10px 15px 10px 15px;
        box-shadow: 5px 5px 10px rgb(112, 112, 112);
    }

    .btn-tambah-user:hover{
        background-color: #2C3245 !important;
        color: white;
    }
    
    .profile-image {
        display: block;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-left: auto;
        margin-right: auto;
    }
    
    .modal-content {
        border-radius: 20px;
    }
    
    .modal-body {
        padding: 2rem 1.5rem;
        font-weight: 600;
        font-size: 1.2rem;
        text-align: center;
    }
    
    .modal-footer {
        justify-content: space-between;
        border-top: none;
        padding: 0 1rem 2rem 1rem;
        display: flex;
    }
    
    .btn-ya {
        background-color: #1F9B30 !important;
        color: white !important;
        border-radius: 10px !important;
        padding: 0.5rem 0 !important;
        font-weight: 600 !important;
        width: 100% !important;
        border: none !important;
        box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25); 
    }
    
    .btn-ya:hover {
        background-color: #218838 !important;
    }
    
    .btn-tidak {
        background-color: #FF3636 !important;
        color: white !important;
        border-radius: 10px !important;
        padding: 0.5rem 0 !important;
        font-weight: 600 !important;
        width: 48% !important;
        border: none !important;
        box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25); 
    }
    
    .btn-tidak:hover {
        background-color: #d9342b !important;
    }
    
    .modal-action-container {
        display: flex;
        justify-content: space-between;
        width: 100%;
        padding: 0 1.5rem;
    }
</style>
@section('content')
<div>
    <h3 class="mb-4"><b>Oke Toys - Data User</b></h3>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered border-secondary table-sm">
            <thead>
                <tr>
                    <th scope="col">Foto User</th>
                    <th scope="col" class="th-color">Nama User</th>
                    <th scope="col">Nomor Telepon</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tanggal Terdaftar</th>
                    <th scope="col">Peran</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user as $u)
                    <tr>
                        <td>
                            @if($u->photo)
                                <img src="{{ asset('storage/profil/'. $u->photo) }}" alt="Profile Image" class="profile-image">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                </svg>
                            @endif
                        </td>
                        <td class="nama-user">{{ $u->name }}</td>
                        <td>{{ $u->phone_number }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->created_at->format('d-m-Y') }}</td>
                        <td>{{ ucfirst($u->role) }}</td>
                        <td>
                            <a class="btn btn-warning" role="button" href="{{ route('edit-user', $u->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                            @if($u->role != 'owner')
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $u->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </button>
                            
                            <div class="modal fade" id="deleteModal{{ $u->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $u->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus User ini?
                                            <div class="modal-action-container mt-4">
                                                <form action="{{ route('hapus-user', $u->id) }}" method="POST" style="width: 48%;margin: 0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-ya">Ya</button>
                                                </form>
                                                <button type="button" class="btn btn-tidak" data-bs-dismiss="modal">Tidak</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('tambah-user') }}" class="btn btn-tambah-user">+ Tambah User</a>
</div>

@endsection
