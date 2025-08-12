<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to TGG Family</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }



        
        .hero {
            background-color: #15789A;
            color: white;
            padding: 100px 20px;
            text-align: center;
        }

        .wave-top {
            position: relative;
            top: -1px;
        }

        .wave-bottom {
            position: relative;
            bottom: -1px;
        }

        .support-section {
            text-align: center;
            padding: 80px 20px;
            background-color: white;
        }

        .support-section p {
            font-size: 1.25rem;
            font-weight: 600;
            color: #222;
        }

        .footer {
            background-color: #15789A;
            color: white;
            padding: 50px 0;
        }

        .footer a {
            color: white;
            margin: 0 8px;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* SVG styling for waves */
        .wave-svg {
            display: block;
            width: 100%;
            height: 100px;
        }
        .wave {
            display: block;
            width: 100%;
            height: auto;
            background: none;
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="mb-3">
                <i class="fas fa-search me-2"></i>
                <strong class="text-uppercase">WELCOME TO TGG FAMILY</strong>
            </div>
            <h1 class="display-5 fw-bold">a holistic and interdependent<br>approach inspired by nature</h1>
        </div>
    </section>

    <!-- Top Wave SVG -->
     <svg class="wave" viewBox="0 0 1000 300" preserveAspectRatio="none">
            <path d="M 1000 299 l 2 -279 c -155 -36 -310 135 -415 164 c -102.64 28.35 -149 -32 -232 -31 
                     c -80 1 -142 53 -229 80 c -65.54 20.34 -101 15 -126 11.61 v 54.39 z" fill="black" />
        </svg>

    <!-- Support Message Section -->
    <section class="support-section">
        <div class="container">
            <p>For professional support you may visit : <a href="https://www.tggindia.com" target="_blank">www.tggindia.com</a></p>
            <p>For hand holding support you may visit : <a href="https://www.tggfct.org" target="_blank">www.tggfct.org</a></p>
        </div>
    </section>

    <!-- Bottom Wave SVG -->
     <svg class="wave" viewBox="0 0 1000 300" preserveAspectRatio="none">
            <path d="M 1000 300 l 1 -230.29 c -217 -12.71 -300.47 129.15 -404 156.29 c -103 27 -174 -30 
                     -257 -29 c -80 1 -130.09 37.07 -214 70 c -61.23 24 -108 15.61 -126 10.61 v 22.39 z" fill="black" />
        </svg>

    <!-- Footer -->
    <footer class="footer">
        <div class="container d-flex justify-content-between align-items-center flex-wrap">
            <div class="text-start">
                &copy; 2025 Powered by TGG India
            </div>
            <div class="text-end">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-pinterest-p"></i></a>
            </div>
        </div>
    </footer>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
