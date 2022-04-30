<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>AdminR - Laravel starter with admin panel and resources generator</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('landing/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('landing/assets/img/apple-touch-icon.png') }} rel=" apple-touch-icon
    ">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('landing/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('landing/assets/css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
    * Template Name: SoftLand - v4.7.0
    * Template URL: https://bootstrapmade.com/softland-bootstrap-app-landing-page-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1 class="position-relative">
                <a href="{{ route('index') }}">{{ getSetting('app_name') }}</a>
                <span style="font-size: 12px; top: -4px; right: -32px" class="text-white position-absolute">v{{ ADMINR_VERSION }}</span>
            </h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="active " href="index.html">Home</a></li>
                <li><a href="features.html">Features</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="contact.html">Contact Us</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section class="hero-section" id="hero">

    <div class="wave">

        <svg width="100%" height="355px" viewBox="0 0 1920 355" version="1.1" xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink">
            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
                    <path
                        d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z"
                        id="Path"></path>
                </g>
            </g>
        </svg>

    </div>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 hero-text-image">
                <div class="row">
                    <div class="col-lg-7 text-center text-lg-start">
                        <h1 data-aos="fade-right">Simple yet powerful <br> laravel admin panel.</h1>
                        <p class="mb-5" data-aos="fade-right" data-aos-delay="100">
                            <span class="fw-bold">AdminR</span> is a great starter for your next laravel project
                            it comes with lots of great features like CRUD Generator and <a href="#features"
                                                                                            class="text-white text-decoration-underline">much
                                more</a>
                        </p>
                        <p data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500">
                            <a href="#" class="btn btn-outline-white">Get Started</a>
                        </p>
                    </div>
                    <div class="col-lg-5 iphone-wrap text-right">
                        <img src="{{ asset('landing/assets/img/phone_1.png') }}" alt="Image" class="phone-1"
                             data-aos="fade-right">
                        <img src="{{ asset('landing/assets/img/phone_2.png') }}" alt="Image" class="phone-2"
                             data-aos="fade-right"
                             data-aos-delay="200">
                    </div>
                </div>
            </div>
        </div>
    </div>

</section><!-- End Hero -->

<main id="main">

    <!-- ======= Home Section ======= -->
    <section class="section">
        <div class="container">

            <div class="row justify-content-center text-center mb-5">
                <div class="col-md-5" data-aos="fade-up">
                    <h2 class="section-heading">Build projects faster with AdminR</h2>
                    <p>You can save around 80% of your time by using our CRUD generator.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="">
                    <div class="feature-1 text-center">
                        <div class="wrap-icon icon-1">
                            <i class="bi bi-people"></i>
                        </div>
                        <h3 class="mb-3">Explore Your Team</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, optio.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-1 text-center">
                        <div class="wrap-icon icon-1">
                            <i class="bi bi-brightness-high"></i>
                        </div>
                        <h3 class="mb-3">Digital Whiteboard</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, optio.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-1 text-center">
                        <div class="wrap-icon icon-1">
                            <i class="bi bi-bar-chart"></i>
                        </div>
                        <h3 class="mb-3">Design To Development</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, optio.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="section">

        <div class="container">
            <div class="row justify-content-center text-center mb-5" data-aos="fade">
                <div class="col-md-6 mb-5">
                    <img src="{{ asset('landing/assets/img/undraw_svg_1.svg')}}" alt="Image" class="img-fluid">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="step">
                        <span class="number">01</span>
                        <h3>Sign Up</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, optio.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step">
                        <span class="number">02</span>
                        <h3>Create Profile</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, optio.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step">
                        <span class="number">03</span>
                        <h3>Enjoy the app</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, optio.</p>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 me-auto">
                    <h2 class="mb-4">Seamlessly Communicate</h2>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur at reprehenderit
                        optio,
                        laudantium eius quod, eum maxime molestiae porro omnis. Dolores aspernatur delectus impedit
                        incidunt
                        dolore mollitia esse natus beatae.</p>
                    <p><a href="#" class="btn btn-primary">Download Now</a></p>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <img src="{{ asset('landing/assets/img/undraw_svg_2.svg')}}" alt="Image" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 ms-auto order-2">
                    <h2 class="mb-4">Gather Feedback</h2>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur at reprehenderit
                        optio,
                        laudantium eius quod, eum maxime molestiae porro omnis. Dolores aspernatur delectus impedit
                        incidunt
                        dolore mollitia esse natus beatae.</p>
                    <p><a href="#" class="btn btn-primary">Download Now</a></p>
                </div>
                <div class="col-md-6" data-aos="fade-right">
                    <img src="{{ asset('landing/assets/img/undraw_svg_3.svg')}}" alt="Image" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- ======= Testimonials Section ======= -->
    <section class="section border-top border-bottom">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-md-4">
                    <h2 class="section-heading">Review From Our Users</h2>
                </div>
            </div>
            <div class="row justify-content-center text-center">
                <div class="col-md-7">

                    <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <div class="review text-center">
                                    <p class="stars">
                                        <span class="bi bi-star-fill"></span>
                                        <span class="bi bi-star-fill"></span>
                                        <span class="bi bi-star-fill"></span>
                                        <span class="bi bi-star-fill"></span>
                                        <span class="bi bi-star-fill muted"></span>
                                    </p>
                                    <h3>Excellent App!</h3>
                                    <blockquote>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea delectus
                                            pariatur, numquam
                                            aperiam dolore nam optio dolorem facilis itaque voluptatum recusandae
                                            deleniti minus animi,
                                            provident voluptates consectetur maiores quos.</p>
                                    </blockquote>

                                    <p class="review-user">
                                        <img src="{{ asset('landing/assets/img/person_1.jpg')}}" alt="Image"
                                             class="img-fluid rounded-circle mb-3">
                                        <span class="d-block">
                        <span class="text-black">Jean Doe</span>, &mdash; App User
                      </span>
                                    </p>

                                </div>
                            </div><!-- End testimonial item -->

                            <div class="swiper-slide">
                                <div class="review text-center">
                                    <p class="stars">
                                        <span class="bi bi-star-fill"></span>
                                        <span class="bi bi-star-fill"></span>
                                        <span class="bi bi-star-fill"></span>
                                        <span class="bi bi-star-fill"></span>
                                        <span class="bi bi-star-fill muted"></span>
                                    </p>
                                    <h3>This App is easy to use!</h3>
                                    <blockquote>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea delectus
                                            pariatur, numquam
                                            aperiam dolore nam optio dolorem facilis itaque voluptatum recusandae
                                            deleniti minus animi,
                                            provident voluptates consectetur maiores quos.</p>
                                    </blockquote>

                                    <p class="review-user">
                                        <img src="{{ asset('landing/assets/img/person_2.jpg')}}" alt="Image"
                                             class="img-fluid rounded-circle mb-3">
                                        <span class="d-block">
                        <span class="text-black">Johan Smith</span>, &mdash; App User
                      </span>
                                    </p>

                                </div>
                            </div><!-- End testimonial item -->

                            <div class="swiper-slide">
                                <div class="review text-center">
                                    <p class="stars">
                                        <span class="bi bi-star-fill"></span>
                                        <span class="bi bi-star-fill"></span>
                                        <span class="bi bi-star-fill"></span>
                                        <span class="bi bi-star-fill"></span>
                                        <span class="bi bi-star-fill muted"></span>
                                    </p>
                                    <h3>Awesome functionality!</h3>
                                    <blockquote>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea delectus
                                            pariatur, numquam
                                            aperiam dolore nam optio dolorem facilis itaque voluptatum recusandae
                                            deleniti minus animi,
                                            provident voluptates consectetur maiores quos.</p>
                                    </blockquote>

                                    <p class="review-user">
                                        <img src="{{ asset('landing/assets/img/person_3.jpg')}}" alt="Image"
                                             class="img-fluid rounded-circle mb-3">
                                        <span class="d-block">
                        <span class="text-black">Jean Thunberg</span>, &mdash; App User
                      </span>
                                    </p>

                                </div>
                            </div><!-- End testimonial item -->

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= CTA Section ======= -->
    <section class="section cta-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 me-auto text-center text-md-start mb-5 mb-md-0">
                    <h2>Starts Publishing Your Apps</h2>
                </div>
                <div class="col-md-5 text-center text-md-end">
                    <p><a href="#" class="btn d-inline-flex align-items-center"><i class="bx bxl-apple"></i><span>App store</span></a>
                        <a href="#" class="btn d-inline-flex align-items-center"><i class="bx bxl-play-store"></i><span>Google play</span></a>
                    </p>
                </div>
            </div>
        </div>
    </section><!-- End CTA Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer class="footer" role="contentinfo">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h3>About SoftLand</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea delectus pariatur, numquam aperiam
                    dolore nam optio dolorem facilis itaque voluptatum recusandae deleniti minus animi.</p>
                <p class="social">
                    <a href="#"><span class="bi bi-twitter"></span></a>
                    <a href="#"><span class="bi bi-facebook"></span></a>
                    <a href="#"><span class="bi bi-instagram"></span></a>
                    <a href="#"><span class="bi bi-linkedin"></span></a>
                </p>
            </div>
            <div class="col-md-7 ms-auto">
                <div class="row site-section pt-0">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h3>Navigation</h3>
                        <ul class="list-unstyled">
                            <li><a href="#">Pricing</a></li>
                            <li><a href="#">Features</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h3>Services</h3>
                        <ul class="list-unstyled">
                            <li><a href="#">Team</a></li>
                            <li><a href="#">Collaboration</a></li>
                            <li><a href="#">Todos</a></li>
                            <li><a href="#">Events</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h3>Downloads</h3>
                        <ul class="list-unstyled">
                            <li><a href="#">Get from the App Store</a></li>
                            <li><a href="#">Get from the Play Store</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center text-center">
            <div class="col-md-7">
                <p class="copyright">&copy; Copyright SoftLand. All Rights Reserved</p>
                <div class="credits">
                    <!--
                    All the links in the footer should remain intact.
                    You can delete the links only if you purchased the pro version.
                    Licensing information: https://bootstrapmade.com/license/
                    Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=SoftLand
                  -->
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
            </div>
        </div>

    </div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset('landing/assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('landing/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('landing/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('landing/assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('landing/assets/js/main.js') }}"></script>

</body>

</html>
