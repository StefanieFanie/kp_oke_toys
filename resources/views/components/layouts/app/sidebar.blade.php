<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Oke Toys</title>
        @include('partials.head')
        <style>
            body {
                background-color: #D5E0FF
            }

            .sidebar {
                height: 100%;
                padding: 10px;
                background-color: #2C3245;
                position: fixed;
                overflow: visible;
            }

            .scroll-sidebar {
                height: 100%;
                overflow-y: auto;
            }

            .sidebar button, .sidebar a {
                display: block;
                color: white;
                padding: 12px;
                margin: 5px;
            }

            .sidebar a.active {
                background-color: #D5E0FF;
                color: #2B2B2B;
                border-radius: 15px;
            }

            .sidebar button:hover, .sidebar a:hover {
                background-color: #3B4B7A;
                color: white;
                border-radius: 15px;
            }

            .dropend {
                cursor: pointer;
                position: inherit;
            }

            .dropdown-menu {
                background-color: #ffffff;
            }

            li .dropdown-item {
                color: #2C3245;
                border: 1px solid #D5E0FF;
                width: 155px;
                border-radius: 15px;
            }

            li .dropdown-item:hover {
                background-color: #D5E0FF;
                width: 155px;
                color: #2C3245;
            }

            .content {
                margin-left: 90px;
                width: calc(100% - 90px);
                z-index: -1;
            }

            @media only screen and (min-width: 901px) {
                .nav-small {
                    display: none;
                }
            }

            @media only screen and (max-width: 900px) {
                .sidebar {
                    display: none;
                }

                .navbar {
                    background-color: #2C3245;
                    position: fixed;
                    width: 100%;
                    z-index: 1;
                }

                .navbar-brand, .nav-item, .nav-link {
                    color: white;
                }

                .navbar-nav {
                    max-height: calc(100vh - 50px);
                    overflow-y: auto
                }

                .nav-item {
                    padding-left: 10px;
                }

                .nav-link.logout {
                    color: #FF3636;
                }

                .navbar-collapse.show {
                    visibility: visible !important;
                }

                .active-small {
                    color: rgb(91, 206, 255);
                    font-weight: 600;
                    padding: 5px 0px 5px 0px;
                    border-radius: 10px;
                }

                .dropdown-menu {
                    background-color: transparent;
                    border: none;
                    padding-left: 10px;
                }

                .content-small {
                    margin: 50px 8px 8px 8px;
                }

                .content {
                    display: none;
                }
            }
        </style>
    </head>
    <body class="min-h-screen flex">
        <div class="sidebar">
            <div class="scroll-sidebar">
                <a style="background-color: #3B4B7A; padding: 10px; border-radius: 10px;" href="#">
                    <x-profile-logo />
                </a><br>
                <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" :current="request()->routeIs('dashboard')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" width=auto height="27" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                        <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z"/>
                    </svg>
                </a>
                <div class="dropend">
                    <a data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width=auto height="27" fill="white" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                        </svg>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Kasir</a></li>
                        <li><a class="dropdown-item" href="#">Stok Masuk</a></li>
                        <li><a class="dropdown-item" href="#">Diskon Reseller</a></li>
                    </ul>
                </div>
                <div class="dropend">
                    <a data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width=auto height="27" fill="white" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                            <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
                            <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                        </svg>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Laporan Penjualan</a></li>
                        <li><a class="dropdown-item" href="#">Laporan Barang</a></li>
                    </ul>
                </div>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width=auto height="27" fill="white" class="bi bi-box" viewBox="0 0 16 16">
                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                    </svg>
                </a>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width=auto height="27" fill="white" class="bi bi-grid-fill" viewBox="0 0 16 16">
                        <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5z"/>
                    </svg>
                </a>
                <div class="dropend">
                    <a data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width=auto height="27" fill="white" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Data Supplier</a></li>
                        <li><a class="dropdown-item" href="#">Data User</a></li>
                    </ul>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="padding-left: 19px">
                        <svg xmlns="http://www.w3.org/2000/svg" width=auto height="27" fill="#FF3636" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        <div class="content">
            {{ $slot }}
        </div>

        <div class="nav-small">
            <nav class="navbar navbar-expand-lg" data-bs-theme="dark">
                <div class="container-fluid">
                    <span class="navbar-brand"><b>Oke Toys</b></span>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active-small' : '' }}" href="{{ route('dashboard') }}" :current="request()->routeIs('dashboard')" wire:navigate>Dashboard</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Transaksi
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="nav-link" href="#">Kasir</a></li>
                                    <li><a class="nav-link" href="#">Stok Masuk</a></li>
                                    <li><a class="nav-link" href="#">Diskon Reseller</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Laporan
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="nav-link" href="#">Laporan Penjualan</a></li>
                                    <li><a class="nav-link" href="#">Laporan Barang</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Produk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Kategori</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Data Lainnya
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="nav-link" href="#">Data Supplier</a></li>
                                    <li><a class="nav-link" href="#">Data User</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link logout">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="content-small">
                {{ $slot }}
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    </body>
</html>
