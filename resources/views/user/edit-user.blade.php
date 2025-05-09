@extends('layout')
@section('title', 'Oke Toys')
<style>
    .btn-simpan {
        background-color: #3B4B7A !important;
        color: white !important;
        font-weight: 600;
        padding: 5px 20px 5px 20px;
        box-shadow: 5px 5px 10px rgb(112, 112, 112);
        margin-top: 10px;
        margin-bottom: 30px;
        float: right;
    }

    .btn-simpan:hover {
        background-color: #2C3245 !important;
        color: white !important;
    }
</style>
@section('content')
<div>
    <h3 class="mb-4"><b>Oke Toys - Edit User</b></h3>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
        <form action="{{ route('update-user',$user->id ?? '')  }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ isset($user) ? $user->name : '' }}" required>
            </div>
            <div class="mb-3">
                <label  abel for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ isset($user) ? $user->email : '' }}" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ isset($user) ? $user->phone_number : '' }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Peran</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="" selected disabled>Pilih Peran</option>
                    <option value="owner" {{ isset($user) && $user->role == 'owner' ? 'selected' : '' }}>Owner</option>
                    <option value="kasir" {{ isset($user) && $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Foto Profil</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="previewImage(this)">
                <div id="preview"></div>
            </div>
        <button type="submit" class="btn btn-simpan">Simpan</button>
    </form>
</div>
@endsection
