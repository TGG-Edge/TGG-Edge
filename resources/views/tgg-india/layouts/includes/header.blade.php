<link href="https://fonts.googleapis.com/css2?family=Belleza&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<style>
    .nav-link {
        /* padding: 10px 12px; */
        font-family: "Belleza", Sans-serif;
        font-weight: 600 !important;
            font-size: 16px;
        color: #000;
        position: relative;
        transition: color 0.3s ease;
        text-decoration: none;
    }

     .nav-link:hover,
    .nav-link.active {
        color: #00aaff !important; /* Light blue text */
    }
    /* Hover underline effect only */
    .nav-link::after {
        content: "";
        display: block;
        width: 0%;
        height: 3px;
        background: #008cff !important;
        margin: auto;
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    .nav-item {
        font-size: medium;
        position: relative;
        list-style: none !important;
        margin: 0;
        padding: 0;
    }

    .social-icon {
      display: flex;
    align-items: center;
    justify-content: center;
    width: 25px !important;
    height: 25px !important;
    background: #222;
    color: #fff;
    border-radius: 50%;
    font-size: 15px !important;
    text-decoration: none;
    }
    
    /* .social-icon:hover {
        transform: scale(1.1);
    } */

    .cart-button {
        position: relative;
        background-color: #000;
        color: #fff;
        border: none;
        padding: 6px 14px;
        border-radius: 5px;
        font-weight: bold;
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    .cart-button .fa-shopping-cart {
        margin-left: 6px;
        font-size: 13px;
    }

    .cart-button .badge {
        position: absolute;
        top: -6px;
        left: 4px;
        font-size: 10px;
        padding: 2px 5px;
    }
</style>

<header class="py-5 shadow-sm bg-white sticky-top header-padding">
    <div class="container d-flex align-items-center justify-content-between flex-wrap">
        
        <!-- Logo -->
        <div class="col-md-3 text-center text-md-start mb-2 mb-md-0" style="margin-left: -60px;">
            <a href="{{ url('https://tggindia.com/') }}">
                <img src="https://tggindia.com/wp-content/uploads/2020/09/cropped-logo_png_final-1024x281.png" alt="TGG India Logo" class="img-fluid" style="max-height: 73px;">
            </a>
        </div>

        <!-- Navigation -->
        <nav class="col-md-6 d-flex flex-column align-items-center" style="margin-right: 25px;">
        
         <button class="mobile-menu-toggle" aria-label="Toggle menu">
            <i class="fas fa-bars"></i>
        </button>

        <div class="menu-container">    
            <ul class="nav justify-content-center">
                <li class="nav-item"><a class="nav-link fw-bold text-dark" href="{{ url('https://tggindia.com/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link fw-bold text-dark" href="https://tggindia.com/about-us/">About Us</a></li>
                <li class="nav-item"><a class="nav-link fw-bold text-dark" href="https://tggindia.com/journey-with-tgg/">Journey with TGG</a></li>
                <li class="nav-item"><a class="nav-link fw-bold text-dark" href="https://tggindia.com/blog-post/">Blog</a></li>
                <li class="nav-item"><a class="nav-link fw-bold text-dark" href="https://thegoldengreens.com/tgg-meta/tgg-india/login/XCJBDSNJK43RWEFSKDJCXNFL34KRN3DKL3MREFWLMNKL32M">Login</a></li>
                 <li class="nav-item"><a class="nav-link fw-bold text-dark" href="https://tggindia.com/contact-us/">Contact Us</a></li>
            </ul>
        </div>
           
        </nav>

        <!-- Cart & Social Icons -->
        <div class="col-md-3 d-flex justify-content-between align-items-center gap-5">
            <!-- Cart -->
            <a href="#" class="btn btn-dark position-relative d-flex align-items-center" style="margin-left: -12px;">
                <i class="fas fa-shopping-cart"></i>
                <span class="ms-2">₹0.00</span>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                0
                </span>
            </a>

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
