<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TGG Onboarding</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Your Chat Widget -->
    <link rel="stylesheet" href="{{ asset('chatbot/css/chat-widget.css') }}">
    <script src="{{ asset('chatbot/js/chat-widget.js') }}"></script>
    <script src="{{ asset('chatbot/js/faqs.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('select[multiple]').forEach(function (el) {
                    new Choices(el, {
                        removeItemButton: true,
                        placeholderValue: el.getAttribute('placeholder') || 'Select options',
                        searchEnabled: true,
                    });
            });
        });

        $(document).ready(function () {

            $('.select2').select2({
                    placeholder: 'Select option',
                    allowClear: true,
                    width: '100%'
            });

        });
    </script>

    <style>
        body { font-family: 'Segoe UI', sans-serif; }

        .hero {
            background:#15789A;
            color:#fff;
            padding:90px 20px;
            text-align:center;
        }

        .steps { padding:80px 20px; }

        .step-card {
            border-radius:14px;
            padding:30px;
            box-shadow:0 4px 15px rgba(0,0,0,.08);
            height:100%;
        }

        .step-icon {
            font-size:34px;
            color:#15789A;
        }

        .cta {
            background:#f7f9fb;
            padding:70px 20px;
            text-align:center;
        }

        .btn-tgg {
            background:#15789A;
            color:#fff;
            padding:12px 40px;
            border-radius:30px;
            border:none;
        }

        .btn-tgg:hover {
            background:#0f5f7a;
            color:#fff;
        }

        .footer {
            background:#15789A;
            color:white;
            padding:40px 0;
        }

        .footer a { color:white; margin:0 8px; }

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

<!-- HERO -->
<section class="hero">
    <div class="container">
        <strong class="text-uppercase">Welcome to TGG Family</strong>
        <div class="display-5 fw-bold">Start your TGG onboarding in a few easy steps — guided by our assistant (Grace Anandita) to ensure a smooth registration, secure payment, and quick application approve.</div>
    </div>
</section>

<!-- STEPS -->
<section class="steps">
    <div class="container">

        <div class="row g-4 text-center">

            <div class="col-md-4">
                <div class="step-card">
                    <i class="fa fa-comments step-icon mb-3"></i>
                     <h5>Step 1 – Start Onboarding</h5>
                    <p>
                        To start onboarding, look at the bottom-right corner of the screen.
                        You will see our chatbot <strong>(Our Assistant, Grace Anandita)</strong>.
                        Open it and click on the available <strong>“Start Onboarding”</strong> option to begin.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="step-card">
                    <i class="fa fa-clipboard-list step-icon mb-3"></i>
                     <h5>Step 2 – Fill Required Details</h5>
                    <p>
                        Fill in the required details in the form and select your role.
                        If you have already enquired for a role earlier, role would be auto selected.
                        After submitting the form, you will be redirected to the payment.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="step-card">
                    <i class="fa fa-credit-card step-icon mb-3"></i>
                    <h5>Step 3 – Complete Payment</h5>
                    <p>
                        After completing the payment, you will be onboarded to TGG Meta.
                        Your application will be reviewed, and login credentials will be provided
                        once your application is approved.
                    </p>
                </div>
            </div>

        </div>

        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <div class="step-card">
                    <i class="fa fa-heart step-icon mb-3"></i>
                    <h5>Welcome to TGG Family</h5>
                    <p>
                        Congratulations! You’re officially part of TGG.
                        Access your dashboard, explore opportunities, and begin your journey with us.
                        <br><br>
                        If you have any issues related to onboarding or anything else,
                        you can use the chatbot at the bottom-right corner 
                        <strong>(Our Assistant, Grace Anandita)</strong>.
                        There you can find FAQs and get your queries resolved quickly.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- CTA -->
<section class="cta">
    <div class="container">
        <h3 class="mb-3">Ready to get started?</h3>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="container d-flex justify-content-between align-items-center flex-wrap">
        <div>&copy; 2025 Powered by TGG India</div>
        <div>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>
