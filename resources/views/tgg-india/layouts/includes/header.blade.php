<link href="https://fonts.googleapis.com/css2?family=Belleza&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<style>
    /* ===== HEADER EXACT MATCH ===== */
    /* ===== HEADER EXACT COLOR + CARD STYLE ===== */

    .header-padding {
        background: #fffff !important;
        /* light grey like image */
        padding: 8px 0 !important;

        /* CARD SHADOW (important) */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    /* LOGO TEXT COLOR FEEL */
    .nav-link {
        color: #000 !important;
    }

    /* ACTIVE MENU COLOR (EXACT BLUE) */
    .nav-link.active {
        color: #1e73be !important;
    }

    /* UNDERLINE SAME BLUE */
    .nav-link::after {
        background: #1e73be !important;
    }

    /* HOVER COLOR */
    .nav-link:hover {
        color: #1e73be !important;
    }

    /* ===== SOCIAL ICON EXACT COLOR ===== */
    .social-icon {
        background: #2f2f2f !important;
        /* dark grey */
        color: #ffffff !important;
    }

    /* HOVER */
    .social-icon:hover {
        background: #000 !important;
    }

    /* ===== HEADER HEIGHT BALANCE ===== */
    .header-container-ipad {
        min-height: 65px;
    }

    /* MAIN CONTAINER */
    .header-container-ipad {
        width: 95% !important;
        margin: 0 auto !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        position: relative;
        flex-wrap: nowrap !important;
    }

    /* REMOVE BOOTSTRAP GRID EFFECT */
    .header-container-ipad>div,
    .header-container-ipad>nav {
        flex: unset !important;
        width: auto !important;
        max-width: none !important;
    }

    /* ===== LOGO ===== */
    .tgg-meta-logo-header {
        height: 50px !important;
        width: auto !important;
    }

    /* ===== CENTER MENU (PERFECT CENTER) ===== */
    .col-md-6 {
        position: absolute !important;
        left: 50%;
        transform: translateX(-50%);
        display: flex !important;
        justify-content: center !important;
    }

    /* MENU LIST */
    .nav {
        display: flex !important;
        gap: 32px !important;
    }

    /* NAV LINKS */
    .nav-link {
        font-family: "Belleza", sans-serif;
        font-size: 15px !important;
        font-weight: 600 !important;
        color: #000 !important;
        padding: 0 !important;
    }

    /* ACTIVE COLOR */
    .nav-link.active {
        color: #007bff !important;
    }

    /* UNDERLINE EFFECT */
    .nav-link::after {
        content: "";
        display: block;
        width: 0%;
        height: 3px;
        background: #007bff;
        margin: 6px auto 0;
        transition: 0.3s;
    }

    .nav-link:hover::after,
    .nav-link.active::after {
        width: 100%;
    }

    /* ===== RIGHT SIDE ICONS ===== */
    .cartnew {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 10px !important;
    }

    /* ===== EXACT SOCIAL ICON STYLE ===== */
    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 32px !important;
        height: 32px !important;

        background: #2d2d2d !important;
        /* exact dark tone */
        color: #fff !important;

        border-radius: 50%;
        font-size: 14px !important;

        text-decoration: none;
    }

    /* ICON ALIGN */
    .social-icon i {
        line-height: 1;
    }

    /* SUBTLE HOVER */
    .social-icon:hover {
        background: #000 !important;
    }

    /* REMOVE EXTRA SPACING */
    body {
        margin: 0;
    }
</style>

<header class="shadow-sm bg-white sticky-top header-padding">
    <div class="container d-flex align-items-center justify-content-between flex-wrap header-container-ipad">

        <!-- Logo -->
        <div class="col-md-3 text-center text-md-start mb-2 mb-md-0">
            <a href="{{ url('https://tggindia.com/') }}">
                <img src="https://tggindia.com/wp-content/uploads/2020/09/cropped-logo_png_final-1024x281.png"
                    alt="TGG India Logo" class="img-fluid tgg-meta-logo-header">
            </a>
        </div>

        <!-- Navigation -->
        <nav class="col-md-6 d-flex flex-column align-items-center" style="margin-right: 25px;">

            <button class="mobile-menu-toggle" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>

            <div class="menu-container">
                <ul class="nav justify-content-center">
                    <li class="nav-item"><a class="nav-link fw-bold text-dark"
                            href="{{ url('https://tggindia.com/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold text-dark"
                            href="https://tggindia.com/about-us/">About Us</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold text-dark"
                            href="http://tggindia.com/our-services/">Our Services</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold text-dark"
                            href="https://tggindia.com/journey-with-tgg/">Journey with TGG</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold text-dark"
                            href="https://tggindia.com/blog-post/">Blog</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold text-dark"
                            href="https://thegoldengreens.com/tgg-meta/tgg-india/login/XCJBDSNJK43RWEFSKDJCXNFL34KRN3DKL3MREFWLMNKL32M">Login</a>
                    </li>
                    <li class="nav-item"><a class="nav-link fw-bold text-dark"
                            href="https://tggindia.com/contact-us/">Contact Us</a></li>
                </ul>
            </div>

        </nav>

        <!-- Cart & Social Icons -->
        <div class="col-md-3 d-flex justify-content-between align-items-center gap-5 cartnew">
            <!-- Cart -->
            {{-- <a href="#" class="btn btn-dark position-relative d-flex align-items-center cart-btn-ipad" style="margin-left: 110px;">
                <i class="fas fa-shopping-cart"></i>
                <span class="ms-2">₹0.00</span>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                0
                </span>
            </a> --}}

            <!-- Social Icons -->
            <div class="d-flex gap-1 align-items-center ms-2">
                <a href="https://www.instagram.com/tggfamily/" class="social-icon" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.facebook.com/TGGIndia" class="social-icon" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.youtube.com/@tggindia" class="social-icon" target="_blank">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggle = document.querySelector(".mobile-menu-toggle");
            const menu = document.querySelector(".menu-container");

            toggle.addEventListener("click", function() {
                menu.classList.toggle("active");
            });
        });
    </script>

</header>
