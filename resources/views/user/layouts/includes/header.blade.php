<link rel="stylesheet" href="{{ asset('assets/user/css/header-footer.css') }}">
 <header class="wrapper_outer">
        <div class="topbar_outer">


            <div class="topbar">
                <div class="container d-flex justify-content-between p-0">
                    <div class="call_mail">
                        <div class="mail">
                            <span><a href="tel:+91-7902677236"> <i class="fas fa-phone"></i>+91-7902677236</a></span>
                        </div>
                        <div class="call">
                            <span><a href="mailto:ebox.tgg@gmail.com"><i
                                        class="fa fa-envelope"></i>ebox.tgg@gmail.com</a></span>
                        </div>
                    </div>


                    <div class="social_media">
                        <ul>
                             {{-- fab fa-facebook --}}
                            <li><a href="https://www.facebook.com/tggfct"><i class=" fab fa-facebook"></i></a></li>
                            <li><a href="https://www.instagram.com/tggfamily/"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="https://twitter.com/tggfct"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="https://www.linkedin.com/company/tggfct/"><i class="fab fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fab fa-whatsapp"></i></a></li>
                            <li><a href="#"><i class="fab fa-telegram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <div class="container p-0">
            <a class="navbar-brand" href="index.html"><img src="{{ asset('assets/user/images/tgg-fnd.jpg')}}"></a>
        </div>

        <nav class="navbar navbar-expand-xl navbar-dark my_navbar_outer">
            <div class="container p-0">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"><i class='icon-menu'></i></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarCollapse">
                    <ul class="navbar-nav nav ">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="https://tggfct.org/">HOME</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="https://tggfct.org/tgg-family/">TGG FAMILY</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="https://tggfct.org/ethos-of-tgg/">ETHOS</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="https://tggfct.org/tsrdg/">OUR GOALS</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="https://tggfct.org/oneworld/">ONEWORLD</a>
                        </li>

                        <!-- <li class="nav-item">
                            <a class="nav-link" href="contact.html">INTERVENTIONS</a>
                        </li> -->

                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="interventionsDropdown" role="button">
                              INTERVENTIONS
                            </a>
                            <div  class="dropdown-menu show-on-hover " style="padding-top: 10px; background: transparent; border: none;">

                                <ul class="dropdown-menu show-on-hover" aria-labelledby="interventionsDropdown" style="margin-top: 0px;">
                                  <li><a class="dropdown-item" href="https://tggfct.org/agriculture-food-production/">Agriculture & Food Production</a></li>
                                  <li><a class="dropdown-item" href="https://tggfct.org/eco-cultural-village/">Eco-Cultural Village</a></li>
                                  <li><a class="dropdown-item" href="https://tggfct.org/ayurgyanam/">Ayurgyanam</a></li>
                                  <li><a class="dropdown-item" href="https://tggfct.org/handicraft/">Handicraft</a></li>
                                  <li><a class="dropdown-item" href="https://tggfct.org/aaranyam/">AARANYAM</a></li>
                                  <li><a class="dropdown-item" href="https://tggfct.org/alternate-education-employability/">Alternate Education & Employability</a></li>
                                  <li><a class="dropdown-item" href="https://tggfct.org/responsible-consumption/">Responsible Consumption</a></li>
                                  <li><a class="dropdown-item" href="https://tggfct.org/civil-right-and-responsibilities/">Civil Rights And Responsibilities</a></li>
                                  <li><a class="dropdown-item" href="https://tggfct.org/rhm-center/">Rural Infrastructure</a></li>
                                  <li><a class="dropdown-item" href="https://tggfct.org/funding-and-monitoring/">Funding And Monitoring</a></li>
                                </ul>
                            </div>
                          </li>

                          

                        <li class="nav-item">
                            <a class="nav-link" href="https://tggfct.org/impact/">IMPACT</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('user/login') ? 'active' : '' }}" href="https://thegoldengreens.com/user/login">USER LOGIN</a>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#"  id="interventionsDropdown" role="button">JOIN US</a>


                            <div  class="dropdown-menu show-on-hover" style="padding-top: 10px; background: transparent; border: none;">

                                <ul class="dropdown-menu show-on-hover" aria-labelledby="interventionsDropdown" style="margin-top: 0px;">
                                  <li><a class="dropdown-item" href="https://tggfct.org/global-citizen/">Global Citizen</a></li>
                                  <li><a class="dropdown-item" href="https://tggfct.org/bridging-the-gap/">Bridging-the-gap</a></li>
                                  <li><a class="dropdown-item" href="https://tggfct.org/tggs-research-innovation/">Sustainability Research</a></li>
                                 
                                </ul>
                            </div>
                        </li>


                    </ul>

                </div>
            </div>
        </nav>



    </header>
