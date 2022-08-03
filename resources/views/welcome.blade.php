<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>AdminR - Laravel starter with admin panel and resources generator</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{{ asset(getSetting('app_favicon')) }}">
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

</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1 class="position-relative">
                <a href="{{ route('index') }}">{{ getSetting('app_name') }}</a>
                <span style="font-size: 12px; top: -4px; right: -32px"
                      class="text-white position-absolute">{{ getVersion(prefix: "v") }}</span>
            </h1>
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="active " href="{{ route('index') }}">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="https://devsbuddy.com/open-source/adminr?ref={{ request()->url() }}">Docs</a></li>
                <li><a href="https://devsbuddy.com/blog">Blog</a></li>
                <li><a href="https://devsbuddy.com/contact-us">Contact Us</a></li>
                <li>
                    <a href="https://github.com/thedevsbuddy/adminr" target="_blank">
                        <svg fill="currentColor" style="width: 24px; height: 24px" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 28 28">
                            <path
                                d="M15,3C8.373,3,3,8.373,3,15c0,5.623,3.872,10.328,9.092,11.63C12.036,26.468,12,26.28,12,26.047v-2.051 c-0.487,0-1.303,0-1.508,0c-0.821,0-1.551-0.353-1.905-1.009c-0.393-0.729-0.461-1.844-1.435-2.526 c-0.289-0.227-0.069-0.486,0.264-0.451c0.615,0.174,1.125,0.596,1.605,1.222c0.478,0.627,0.703,0.769,1.596,0.769 c0.433,0,1.081-0.025,1.691-0.121c0.328-0.833,0.895-1.6,1.588-1.962c-3.996-0.411-5.903-2.399-5.903-5.098 c0-1.162,0.495-2.286,1.336-3.233C9.053,10.647,8.706,8.73,9.435,8c1.798,0,2.885,1.166,3.146,1.481C13.477,9.174,14.461,9,15.495,9 c1.036,0,2.024,0.174,2.922,0.483C18.675,9.17,19.763,8,21.565,8c0.732,0.731,0.381,2.656,0.102,3.594 c0.836,0.945,1.328,2.066,1.328,3.226c0,2.697-1.904,4.684-5.894,5.097C18.199,20.49,19,22.1,19,23.313v2.734 c0,0.104-0.023,0.179-0.035,0.268C23.641,24.676,27,20.236,27,15C27,8.373,21.627,3,15,3z"/>
                        </svg>
                    </a>
                </li>
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
                            <a href="#features" class="btn btn-outline-white">Know More</a>
                        </p>
                    </div>
                    <div class="col-lg-5 iphone-wrap text-right">
                        <img src="{{ asset('landing/assets/img/hero-right-image.svg') }}" alt="Image"
                             style="max-width: 65%"
                             class="d-block mx-auto my-5 my-md-auto"
                             data-aos="fade-right">
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
                    <p>You can save upto 80% of your time by using our CRUD generator.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="">
                    <div class="feature-1 text-center">
                        <div class="wrap-icon icon-1">
                            <i class="bi bi-hammer"></i>
                        </div>
                        <h3 class="mb-3">Generate Resources</h3>
                        <p>You can generate any CRUD resource with beautiful GUI.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-1 text-center">
                        <div class="wrap-icon icon-1">
                            <i class="bi bi-gear-wide-connected"></i>
                        </div>
                        <h3 class="mb-3">Generate APIs</h3>
                        <p>AdminR allows you to generate APIs with the Resources.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-1 text-center">
                        <div class="wrap-icon icon-1">
                            <i class="bi bi-asterisk"></i>
                        </div>
                        <h3 class="mb-3">Manage Permissions</h3>
                        <p>We allow you to manage APIs and CRUD permissions with ease.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="section" id="features">

        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-md-5" data-aos="fade-up">
                    <h2 class="section-heading">Key Features</h2>
                    <p>We cover some major features to help you generate or create admin panel with ease.</p>
                </div>
            </div>

            <div class="py-5">
                <div class="row align-items-center">
                    <div class="col-md-4 me-auto order-2 order-lg-0">
                        <h2 class="mb-4">CRUD Generation</h2>
                        <p class="mb-4">
                            AdminR has a powerful tool to generate CRUDs by using easy to use GUI
                            which can generate a CRUD for you within minutes, And save you a lot of time which you
                            invest while writing code by yourself.
                        </p>
                        <p><a href="{{ route(config('adminr.route_prefix'). '.builder') }}" class="btn btn-primary">Start
                                Generating</a></p>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <img src="{{ asset('landing/assets/img/feature-crud.svg')}}" alt="Image" class="d-block mx-auto w-75">
                    </div>
                </div>
            </div>

            <div class="py-5">
                <div class="row align-items-center">
                    <div class="col-md-4 ms-auto order-2">
                        <h2 class="mb-4">Generate APIs</h2>
                        <p class="mb-4">
                            It can take hours to create APIs with all the features for each and every resource you have
                            instead you can generate the APIs while generating resources with the help of our awesome tool
                            which helps you generate the resources and APIs with ease.
                        </p>
{{--                        <p><a href="#" class="btn btn-primary">Download Now</a></p>--}}
                    </div>
                    <div class="col-md-6" data-aos="fade-right">
                        <img src="{{ asset('landing/assets/img/feature-apis.svg')}}" alt="Image" class="d-block mx-auto w-75">
                    </div>
                </div>
            </div>

            <div class="py-5">
                <div class="row align-items-center">
                    <div class="col-md-4 me-auto order-2 order-lg-0">
                        <h2 class="mb-4">Manage CRUD permissions</h2>
                        <p class="mb-4">
                            AdminR provides you easy to use GUI to manage permissions for each and every resource
                            you generate so you can provide appropriate permissions to each user role.
                        </p>
{{--                        <p><a href="{{ route(config('adminr.route_prefix'). '.builder') }}" class="btn btn-primary">Start--}}
{{--                                Generating</a></p>--}}
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <img src="{{ asset('landing/assets/img/feature-permission.svg')}}" alt="Image" class="d-block mx-auto w-75">
                    </div>
                </div>
            </div>

            <div class="py-5">
                <div class="row align-items-center">
                    <div class="col-md-4 ms-auto order-2">
                        <h2 class="mb-4">Manage APIs permissions</h2>
                        <p class="mb-4">
                            Managing each and every API with permissions is really pain in <strong>brain</strong>
                            but AdminR covers you with that.
                            AdminR provides you an easy to manage dashboard to allow or remove permissions for any API
                            which can be consumed by public or authenticated users.
                        </p>
                    </div>
                    <div class="col-md-6" data-aos="fade-right">
                        <img src="{{ asset('landing/assets/img/feature-permission-api.svg')}}" alt="Image" class="d-block mx-auto w-75">
                    </div>
                </div>
            </div>

        </div>

    </section>


{{--    <!-- ======= Testimonials Section ======= -->--}}
{{--    <section class="section border-top border-bottom">--}}
{{--        <div class="container">--}}
{{--            <div class="row justify-content-center text-center mb-5">--}}
{{--                <div class="col-md-4">--}}
{{--                    <h2 class="section-heading">Review From Our Users</h2>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row justify-content-center text-center">--}}
{{--                <div class="col-md-7">--}}

{{--                    <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">--}}
{{--                        <div class="swiper-wrapper">--}}

{{--                            <div class="swiper-slide">--}}
{{--                                <div class="review text-center">--}}
{{--                                    <p class="stars">--}}
{{--                                        <span class="bi bi-star-fill"></span>--}}
{{--                                        <span class="bi bi-star-fill"></span>--}}
{{--                                        <span class="bi bi-star-fill"></span>--}}
{{--                                        <span class="bi bi-star-fill"></span>--}}
{{--                                        <span class="bi bi-star-fill muted"></span>--}}
{{--                                    </p>--}}
{{--                                    <h3>Excellent App!</h3>--}}
{{--                                    <blockquote>--}}
{{--                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea delectus--}}
{{--                                            pariatur, numquam--}}
{{--                                            aperiam dolore nam optio dolorem facilis itaque voluptatum recusandae--}}
{{--                                            deleniti minus animi,--}}
{{--                                            provident voluptates consectetur maiores quos.</p>--}}
{{--                                    </blockquote>--}}

{{--                                    <p class="review-user">--}}
{{--                                        <img src="{{ asset('landing/assets/img/person_1.jpg')}}" alt="Image"--}}
{{--                                             class="img-fluid rounded-circle mb-3">--}}
{{--                                        <span class="d-block">--}}
{{--                        <span class="text-black">Jean Doe</span>, &mdash; App User--}}
{{--                      </span>--}}
{{--                                    </p>--}}

{{--                                </div>--}}
{{--                            </div><!-- End testimonial item -->--}}

{{--                            <div class="swiper-slide">--}}
{{--                                <div class="review text-center">--}}
{{--                                    <p class="stars">--}}
{{--                                        <span class="bi bi-star-fill"></span>--}}
{{--                                        <span class="bi bi-star-fill"></span>--}}
{{--                                        <span class="bi bi-star-fill"></span>--}}
{{--                                        <span class="bi bi-star-fill"></span>--}}
{{--                                        <span class="bi bi-star-fill muted"></span>--}}
{{--                                    </p>--}}
{{--                                    <h3>This App is easy to use!</h3>--}}
{{--                                    <blockquote>--}}
{{--                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea delectus--}}
{{--                                            pariatur, numquam--}}
{{--                                            aperiam dolore nam optio dolorem facilis itaque voluptatum recusandae--}}
{{--                                            deleniti minus animi,--}}
{{--                                            provident voluptates consectetur maiores quos.</p>--}}
{{--                                    </blockquote>--}}

{{--                                    <p class="review-user">--}}
{{--                                        <img src="{{ asset('landing/assets/img/person_2.jpg')}}" alt="Image"--}}
{{--                                             class="img-fluid rounded-circle mb-3">--}}
{{--                                        <span class="d-block">--}}
{{--                        <span class="text-black">Johan Smith</span>, &mdash; App User--}}
{{--                      </span>--}}
{{--                                    </p>--}}

{{--                                </div>--}}
{{--                            </div><!-- End testimonial item -->--}}

{{--                            <div class="swiper-slide">--}}
{{--                                <div class="review text-center">--}}
{{--                                    <p class="stars">--}}
{{--                                        <span class="bi bi-star-fill"></span>--}}
{{--                                        <span class="bi bi-star-fill"></span>--}}
{{--                                        <span class="bi bi-star-fill"></span>--}}
{{--                                        <span class="bi bi-star-fill"></span>--}}
{{--                                        <span class="bi bi-star-fill muted"></span>--}}
{{--                                    </p>--}}
{{--                                    <h3>Awesome functionality!</h3>--}}
{{--                                    <blockquote>--}}
{{--                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea delectus--}}
{{--                                            pariatur, numquam--}}
{{--                                            aperiam dolore nam optio dolorem facilis itaque voluptatum recusandae--}}
{{--                                            deleniti minus animi,--}}
{{--                                            provident voluptates consectetur maiores quos.</p>--}}
{{--                                    </blockquote>--}}

{{--                                    <p class="review-user">--}}
{{--                                        <img src="{{ asset('landing/assets/img/person_3.jpg')}}" alt="Image"--}}
{{--                                             class="img-fluid rounded-circle mb-3">--}}
{{--                                        <span class="d-block">--}}
{{--                        <span class="text-black">Jean Thunberg</span>, &mdash; App User--}}
{{--                      </span>--}}
{{--                                    </p>--}}

{{--                                </div>--}}
{{--                            </div><!-- End testimonial item -->--}}

{{--                        </div>--}}
{{--                        <div class="swiper-pagination"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section><!-- End Testimonials Section -->--}}

    <!-- ======= CTA Section ======= -->
    <section class="section cta-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 me-auto text-center text-md-start mb-5 mb-md-0">
                    <h2>Start building your project.</h2>
                </div>
                <div class="col-md-5 text-center text-md-end">
                    <p>
                        <a href="{{ route(config('adminr.route_prefix').'.builder') }}" class="btn d-inline-flex align-items-center"><i class="bi bi-chevron-right"></i><span class="ms-2">Start Now</span></a>

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
                <h3>About AdminR</h3>
                <p>
                    AdminR is an open source project created by <a href="https://devsbuddy.com/team/shoaib-khan">Shoaib Khan</a>
                    Who is a member and owner of <a href="https://devsbuddy.com/about">Devsbuddy</a>
                </p>
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
                            <li><a href="{{ route('index') }}">Home</a></li>
                            <li><a href="#features">Features</a></li>
                            <li><a href="https://devsbuddy.com/blog">Blog</a></li>
                            <li><a href="https://devsbuddy.com/contact-us">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h3>Useful Links</h3>
                        <ul class="list-unstyled">
                            <li><a href="https://docspace.dev" target="_blank">Docspace</a></li>
                            <li><a href="https://devsbuddy.com/open-source">Other Open Projects</a></li>
                            <li><a href="https://devsbuddy.com/terms-and-conditions">Terms & conditions</a></li>
                            <li><a href="https://devsbuddy.com/privacy-policy">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h3>Credits</h3>
                        <div class="credits pt-3">
                            <p class="m-0">Developed with <i class="bi bi-heart-fill text-danger"></i> and dedication by <a href="https://devsbuddy.com/team/shoaib-khan" target="_blank">Shoaib Khan</a></p>
                            <p class="m-0">Template by <a href="https://bootstrapmade.com/">BootstrapMade</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center text-center mt-4">
            <div class="col-md-7">
                <p class="copyright">Copyright &copy; {{ date('Y') }}. All Rights Reserved by <a href="https://devsbuddy.com/" target="_blank">Devsbuddy</a></p>
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
