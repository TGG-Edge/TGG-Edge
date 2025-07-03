<header class="py-3 shadow-sm bg-white sticky-top">
    <div class="container d-flex align-items-center justify-content-between flex-wrap">
        
        {{-- Logo --}}
        <div class="col-md-3 text-center text-md-start mb-2 mb-md-0">
            <a href="{{ url('/') }}">
                <img src="https://tggindia.com/wp-content/uploads/2020/09/cropped-logo_png_final-1024x281.png" alt="TGG India Logo" class="img-fluid" style="max-height: 60px;">
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="col-md-6 d-flex justify-content-center">
            <ul class="nav">
                <li class="nav-item"><a class="nav-link fw-bold text-dark" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link fw-bold text-dark" href="https://tggindia.com/about-us/">About Us</a></li>
                <li class="nav-item"><a class="nav-link fw-bold text-dark" href="https://tggindia.com/blog-post/">Blog</a></li>
                <li class="nav-item"><a class="nav-link fw-bold text-dark" href="https://tggindia.com/journey-with-tgg/">Journey with TGG</a></li>
                <li class="nav-item"><a class="nav-link fw-bold text-dark" href="https://tggindia.com/my-account/">My Account</a></li>
                <li class="nav-item"><a class="nav-link fw-bold text-dark" href="https://tggindia.com/contact-us/">Contact Us</a></li>
            </ul>
        </nav>

        {{-- Cart & Social Icons --}}
        <div class="col-md-3 d-flex justify-content-center justify-content-md-end align-items-center gap-3">
            {{-- Cart --}}
            <a href="#" class="btn btn-dark position-relative">
                ₹0.00
                <i class="fas fa-shopping-cart ms-2"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    0
                </span>
            </a>

           {{-- Social Icons with no underline --}}
          <div class="d-flex gap-2">
              <a href="https://www.instagram.com/tggfamily/" 
                class="d-inline-flex align-items-center justify-content-center bg-dark rounded-circle text-white text-decoration-none" 
                style="width: 35px; height: 35px;" 
                target="_blank">
                  <i class="fab fa-instagram"></i>
              </a>
              <a href="https://www.facebook.com/TGGIndia" 
                class="d-inline-flex align-items-center justify-content-center bg-dark rounded-circle text-white text-decoration-none" 
                style="width: 35px; height: 35px;" 
                target="_blank">
                  <i class="fab fa-facebook-f"></i>
              </a>
              <a href="https://www.youtube.com/@tggindia" 
                class="d-inline-flex align-items-center justify-content-center bg-dark rounded-circle text-white text-decoration-none" 
                style="width: 35px; height: 35px;" 
                target="_blank">
                  <i class="fab fa-youtube"></i>
              </a>
          </div>

        </div>
    </div>
</header>
