<style>
    .input-search {
        position: relative;
    }

    .form-control {
        padding-left: 42px;
    }

    .bi-search {
        transform: translateY(-50%);
        left: 10px;
        top: 19px;
        position: absolute;
    }

    .dropdown-menu {
        background-color: #ffffff;
    }

    li .dropdown-item {
        color: #2C3245;
        border: 1px solid #D5E0FF;
        width: 200px;
        margin: 5px;
        border-radius: 10px;
        padding: 10px 0 10px 10px;
    }

    li .dropdown-item:hover {
        width: 200px;
    }

    th, td {
        background-color: #E4EBFF !important;
        text-align: center;
        color: #2C3245 !important;
    }

    .nama-produk {
        max-width: 250px;
        text-align: left;
    }

    .btn {
        padding: 0px 8px 3px 8px;
    }

    .btn-tambah-produk {
        background-color: #3B4B7A;
        color: white;
        font-weight: 600;
        bottom: 30px;
        right: 30px;
        position: fixed;
        padding: 10px 15px 10px 15px;
        box-shadow: 5px 5px 10px rgb(112, 112, 112);
    }

    .btn-tambah-produk:hover{
        background-color: #2C3245;
        color: white;
    }
</style>
<div>
    <h3 class="mb-4"><b>Oke Toys - Produk</b></h3>
    <form class="d-flex input-search" role="search">
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="#3B4B7A" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
        </svg>
        <input class="form-control me-2" type="search" placeholder="Cari produk..." aria-label="Search">
        <div class="dropdown">
            <button type="button" class="btn btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="35" fill="#3B4B7A" class="bi bi-funnel" viewBox="0 0 16 16">
                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                </svg>
            </button>
            <ul class="dropdown-menu">
                <li><button class="dropdown-item" type="button">Mainan Edukasi</button></li>
                <li><button class="dropdown-item" type="button">Kategori 2</button></li>
                <li><button class="dropdown-item" type="button">Kategori 3</button></li>
            </ul>
        </div>
    </form><br>
    <div class="table-responsive">
        <table class="table table-bordered border-secondary table-sm">
            <thead>
                <tr>
                    <th scope="col" class="th-color">Nama Produk</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Harga Modal</th>
                    <th scope="col">Harga Jual</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($list_produk as $produk)
                    <tr>
                        <td class="nama-produk">{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->kategori->nama_kategori  }}</td>
                        <td>Rp {{ $produk->harga_modal }}</td>
                        <td>Rp {{ $produk->harga_jual }}</td>
                        <td>
                            <a class="btn btn-warning" role="button" href="{{ route('produk/edit-produk') }}" :current="request()->routeIs('edit-produk')" wire:navigate>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                            <a class="btn btn-danger" role="button" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <div class="alert alert-danger">
                        Belum ada produk
                    </div>
                @endforelse
            </tbody>
        </table>
    </div>
    <a href="{{ route('produk/tambah-produk') }}" class="btn btn-tambah-produk" :current="request()->routeIs('produk')" wire:navigate>+ Tambah Produk</a>
</div>
