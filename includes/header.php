<!-- =========================
FILE: includes/header.php
========================= -->

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Swapnavennam - Premium Escort Services in Hyderabad</title>

    <meta name="description"
        content="Book premium escort services and independent call girls in Hyderabad with Swapnavennam.">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- BOOTSTRAP JS (needed for dropdown) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- LOCATIONS DROPDOWN STYLES (header-scoped) -->
    <style>
        .nav-item.dropdown .dropdown-toggle::after{
            border:0;
            content:"\f107";
            font-family:"Font Awesome 6 Free";
            font-weight:900;
            font-size:11px;
            margin-left:6px;
            vertical-align:middle;
        }
        .locations-menu{
            background:#1a1a1a;
            border:1px solid rgba(255,45,85,0.25);
            border-radius:14px;
            padding:14px;
            margin-top:14px;
            min-width:520px;
            box-shadow:0 20px 50px rgba(0,0,0,0.5);
        }
        .locations-menu .loc-title{
            display:block;
            color:#ff2d55;
            font-size:11px;
            font-weight:700;
            text-transform:uppercase;
            letter-spacing:2px;
            padding:6px 14px 10px;
            border-bottom:1px solid rgba(255,255,255,0.08);
            margin-bottom:8px;
        }
        .locations-menu .row-loc{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:4px;
        }
        .locations-menu a.dropdown-item{
            color:#dcdcdc;
            font-size:14px;
            padding:10px 14px;
            border-radius:8px;
            transition:0.25s;
            display:flex;
            align-items:center;
            gap:10px;
        }
        .locations-menu a.dropdown-item i{
            color:#ff2d55;
            font-size:11px;
            transition:0.25s;
        }
        .locations-menu a.dropdown-item:hover{
            background:rgba(255,45,85,0.10);
            color:#fff;
            transform:translateX(3px);
        }
        .locations-menu a.dropdown-item:hover i{
            color:#fff;
        }
        @media(max-width:991px){
            .locations-menu{
                min-width:auto;
                margin-top:8px;
                padding:10px;
                background:rgba(255,255,255,0.04);
                border:1px solid rgba(255,255,255,0.08);
                box-shadow:none;
            }
            .locations-menu .row-loc{grid-template-columns:1fr}
        }
    </style>

</head>

<body>

    <!-- HEADER START -->
    <header class="main-header">

        <div class="container">

            <nav class="navbar navbar-expand-lg">

                <!-- LOGO -->
                <a class="navbar-brand" href="index.php">
                    <span>Swapna</span>Vennam
                </a>

                <!-- MOBILE TOGGLE -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainMenu">

                    <span class="navbar-toggler-icon">
                        <i class="fa-solid fa-bars"></i>
                    </span>

                </button>

                <!-- MENU -->
                <div class="collapse navbar-collapse" id="mainMenu">

                    <ul class="navbar-nav ms-auto align-items-lg-center">

                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Escorts
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Hyderabad
                            </a>
                        </li>

                        <!-- LOCATIONS DROPDOWN START -->
                        <li class="nav-item dropdown">

                            <a class="nav-link dropdown-toggle" href="#" id="locationsDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Locations
                            </a>

                            <div class="dropdown-menu locations-menu" aria-labelledby="locationsDropdown">

                                <span class="loc-title">
                                    <i class="fa-solid fa-location-dot me-1"></i>
                                    12 Premium Hyderabad Areas
                                </span>

                                <div class="row-loc">

                                    <a class="dropdown-item" href="locations/kondapur.php">
                                        <i class="fa-solid fa-map-pin"></i> Kondapur
                                    </a>

                                    <a class="dropdown-item" href="locations/hitech-city.php">
                                        <i class="fa-solid fa-map-pin"></i> Hitech City
                                    </a>

                                    <a class="dropdown-item" href="locations/gachibowli.php">
                                        <i class="fa-solid fa-map-pin"></i> Gachibowli
                                    </a>

                                    <a class="dropdown-item" href="locations/banjara-hills.php">
                                        <i class="fa-solid fa-map-pin"></i> Banjara Hills
                                    </a>

                                    <a class="dropdown-item" href="locations/madhapur.php">
                                        <i class="fa-solid fa-map-pin"></i> Madhapur
                                    </a>

                                    <a class="dropdown-item" href="locations/jubilee-hills.php">
                                        <i class="fa-solid fa-map-pin"></i> Jubilee Hills
                                    </a>

                                    <a class="dropdown-item" href="locations/somajiguda.php">
                                        <i class="fa-solid fa-map-pin"></i> Somajiguda
                                    </a>

                                    <a class="dropdown-item" href="locations/shamshabad.php">
                                        <i class="fa-solid fa-map-pin"></i> Shamshabad
                                    </a>

                                    <a class="dropdown-item" href="locations/begumpet.php">
                                        <i class="fa-solid fa-map-pin"></i> Begumpet
                                    </a>

                                    <a class="dropdown-item" href="locations/lakdikapul.php">
                                        <i class="fa-solid fa-map-pin"></i> Lakdikapul
                                    </a>

                                    <a class="dropdown-item" href="locations/masab-tank.php">
                                        <i class="fa-solid fa-map-pin"></i> Masab Tank
                                    </a>

                                    <a class="dropdown-item" href="locations/panjagutta.php">
                                        <i class="fa-solid fa-map-pin"></i> Panjagutta
                                    </a>

                                </div>

                            </div>

                        </li>
                        <!-- LOCATIONS DROPDOWN END -->

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                VIP Girls
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Contact
                            </a>
                        </li>

                        <li class="nav-item ms-lg-3">
                            <a href="#" class="header-btn">
                                Book Now
                            </a>
                        </li>

                    </ul>

                </div>

            </nav>

        </div>

    </header>
    <!-- HEADER END -->
