<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
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
            z-index: 1000;
        }

        .scroll-sidebar {
            height: 100%;
            overflow-y: auto;
        }

        .profile-icon {
            background-color: #3B4B7A;
            padding: 10px;
            border-radius: 50%;
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

        .button-logout {
            width: 87%;
            display: block;
            padding: 12px;
            background-color: transparent;
            border: none;
        }

        .content {
            padding: 20px 0 0 120px;
            width: calc(100% - 30px);
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
                position: sticky;
                top: 0;
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

            .content {
                margin: 12px;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    @include('include.navigation-menu')
    <div class="content">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>
