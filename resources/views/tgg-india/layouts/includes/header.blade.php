<style>
.custom-tgg-header {
z-index: 10;
    position: sticky;
    top: 0;
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    border-bottom: 1px solid #02010175;
    padding: 15px 20px;
    width: 100%;
}

.header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    max-width: 1400px;
    padding: 0 1rem;
    gap: 50px;
}

.nav-social-contianer {
    display: flex;
    align-items: center;
    gap: 50px;
}



/* Logo */
.header-logo img {
    height: 40px;
    max-width: 100%;
    object-fit: contain;
}

/* Top Navigation Links */
.header-nav {
    flex: 1;
    display: flex;
    justify-content: center;
}

.nav-list {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 25px;
}

.nav-list a {
    text-decoration: none;
    color: #212529;
    font-weight: 500;
    font-size: 14px;
    transition: color 0.2s ease-in-out;
}

.nav-list a:hover {
    color: #0d6efd;
    /* Highlight color on hover */
}

/* Social Icons */
.header-social {
    display: flex;
    align-items: center;
    gap: 15px;
}

.social-icon {
    color: #262626;
    font-size: 1.2rem;
    text-decoration: none;
    transition: color 0.2s ease-in-out;
}

.social-icon:hover {
    color: #0d6efd;
}

.icon {
    color: #262626;
    width: 25px;
    height: 25px
}

.menu-icon {
    width: 25px;
    height: 25px;
    color: #101828;
}

.mobile-sidebar-toggle {
    width: 25px;
    height: 25px;
    display: none;
    background: transparent;
    border: none;
    font-size: 1.5rem;
    color: #212529;
    cursor: pointer;
    padding: 5px;
}



/* --- Responsive Rules (Mobile & Tablet) --- */
@media (max-width: 991.98px) {

    /* Hide the top text navigation on mobile */
    .header-nav {
        display: none;
    }

    /* Show the hamburger menu button */
    .mobile-sidebar-toggle {
        display: block;
    }

    /* Reorder items on mobile so toggle is on left, logo center, social right */
    .header-container {
        justify-content: space-between;
    }

    .header-logo {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }
}

/* Extra small screens fix to hide social icons if it gets too crowded */
@media (max-width: 400px) {
    .header-social {
        display: none;
    }
}
</style>



<header class="custom-tgg-header">
    <div class="header-container">

        <!-- 1. Mobile Sidebar Toggle Button (Shows ONLY on small screens) -->


        <!-- 2. Logo -->
        <div class="header-logo">
            <a href="{{ url('https://tggindia.com/') }}">
                <img src="https://tggindia.com/wp-content/uploads/2020/09/cropped-logo_png_final-1024x281.png"
                    alt="TGG India Logo">
            </a>

            <button id="mobileSidebarToggle" class="mobile-sidebar-toggle" aria-label="Open Sidebar">
                <x-eva-menu class="menu-icon" />
            </button>
        </div>



        <!-- 3. Navigation Links and Social Icons  -->
        <div class="nav-social-contianer">
            <!-- 3. Navigation Links (Hidden on small screens) -->
            <nav class="header-nav">
                <ul class="nav-list">
                    <li><a href="{{ url('https://tggindia.com/') }}">Home</a></li>
                    <li><a href="https://tggindia.com/about-us/">About Us</a></li>
                    <li><a href="http://tggindia.com/our-services/">Our Services</a></li>
                    <li><a href="https://tggindia.com/journey-with-tgg/">Journey with TGG</a></li>
                    <li><a href="https://tggindia.com/blog-post/">Blog</a></li>
                    <li><a
                            href="https://thegoldengreens.com/tgg-meta/tgg-india/login/XCJBDSNJK43RWEFSKDJCXNFL34KRN3DKL3MREFWLMNKL32M">Login</a>
                    </li>
                    <li><a href="https://tggindia.com/contact-us/">Contact Us</a></li>
                </ul>
            </nav>

            <!-- 4. Social Icons -->
            <div class="header-social">
                <a href="https://www.instagram.com/tggfamily/" class="social-icon" target="_blank">
                    <x-entypo-instagram-with-circle class="icon" />
                </a>
                <a href="https://www.facebook.com/TGGIndia" class="social-icon" target="_blank">
                    <x-entypo-facebook-with-circle class="icon" />
                </a>
                <a href="https://www.youtube.com/@tggindia" class="social-icon" target="_blank">
                    <x-entypo-youtube-with-circle class="icon" />
                </a>
            </div>
        </div>


    </div>
</header>