<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="msapplication-TileColor" content="#0E0E0E">
    <meta name="template-color" content="#0E0E0E">
    <meta name="description" content="Accueil">
    <meta name="keywords" content="Poste, Gabon">
    <meta name="author" content="JOBS">
    <link href="{{ URL::to('assets/dist/images/logos/icon_bleu.png') }}" rel="shortcut icon">
    <link href="{{ asset('front/css/style28b5.css') }}" rel="stylesheet">
    <title>La Poste Gabonaise</title>
</head>

<body>
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <img alt="Poste" src="{{ asset('front/imgs/laposte.png') }}">
            </div>
        </div>
    </div>
    <div class="box-bar" style="background-color: #1c4599;">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-8 col-sm-5 col-4"> <a class="phone-icon mr-45" href="tel:+01-246-357">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z">
                            </path>
                        </svg>Téléphone: +241 7 246 357</a><a class="email-icon" href="mailto:contact@transp.eu.com">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75">
                            </path>
                        </svg>contact@laposte-ga.com</a></div>
                <div class="col-lg-5 col-md-4 col-sm-7 col-8 text-end"><a class="icon-socials icon-twitter2"
                        href="#">
                        <svg class="bi bi-twitter" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            fill="" viewbox="0 0 16 16">
                            <path
                                d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z">
                            </path>
                        </svg></a><a class="icon-socials icon-facebook2" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 24 24">
                            <path
                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z">
                            </path>
                        </svg></a><a class="icon-socials icon-instagram2" href="#">
                        <svg class="bi bi-instagram" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewbox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z">
                            </path>
                        </svg></a><a class="icon-socials icon-youtube2" href="#">
                        <svg class="bi bi-youtube" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewbox="0 0 24 24">
                            <path
                                d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z">
                            </path>
                        </svg></a><a class="icon-socials icon-skype2" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 24 24">
                            <path
                                d="M22.987 13.966c1.357-7.765-5.416-14.412-13.052-12.979-5.821-3.561-12.503 3.226-8.935 9.029-1.387 7.747 5.384 14.48 13.083 13.01 5.832 3.536 12.493-3.26 8.904-9.06zm-10.603 5.891c-3.181 0-6.378-1.448-6.362-3.941.005-.752.564-1.442 1.309-1.442 1.873 0 1.855 2.795 4.837 2.795 2.093 0 2.807-1.146 2.807-1.944 0-2.886-9.043-1.117-9.043-6.543 0-2.938 2.402-4.962 6.179-4.741 3.602.213 5.713 1.803 5.917 3.289.101.971-.542 1.727-1.659 1.727-1.628 0-1.795-2.181-4.6-2.181-1.266 0-2.334.528-2.334 1.674 0 2.395 8.99 1.005 8.99 6.276-.001 3.039-2.423 5.031-6.041 5.031z">
                            </path>
                        </svg></a></div>
            </div>
        </div>
    </div>
    <header class="header sticky-bar">
        <div class="container">
            <div class="main-header">
                <div class="header-left">
                    <div class="header-logo"><a class="d-flex" href="{{ route('accueil') }}"><img alt="Ecom"
                                src="{{ asset('front/imgs/laposte.png') }}"></a></div>
                    <div class="header-nav">
                        <nav class="nav-main-menu d-none d-xl-block">
                            <ul class="main-menu">
                                <li><a href="#">Accueil</a></li>
                                <li><a href="#">A Propos</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">Contact</a></li>
                                <li>
                                    @if (!isset($user))
                                        <a class="btn btn-default mr-10 hover-up"
                                            href="{{ route('login') }}">Connexion</a>
                                    @else
                                        <a class="btn btn-brand-1 mr-10 hover-up"
                                            href="{{ route('adminHome') }}">Administration</a>
                                    @endif
                                </li>
                            </ul>
                        </nav>
                        <div class="burger-icon burger-icon-white"><span class="burger-icon-top"></span><span
                                class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
                    </div>


                </div>
            </div>
        </div>
    </header>

    <div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-content-area">

                <div class="burger-icon"><span class="burger-icon-top"></span><span
                        class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
                <div class="perfect-scroll">
                    <div class="mobile-menu-wrap mobile-header-border">
                        <nav class="mt-15">
                            <ul class="mobile-menu font-heading">
                                <li><a href="#">Accueil</a></li>
                                <li><a href="#">A Propos</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">Contact</a></li>
                                <li>
                                    @if (!isset($user))
                                        <a class="btn btn-default mr-10 hover-up"
                                            href="{{ route('login') }}">Connexion</a>
                                    @else
                                        <a class="btn btn-brand-1 mr-10 hover-up"
                                            href="{{ route('adminHome') }}">Administration</a>
                                    @endif
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="site-copyright color-grey-400 mt-0">

                        <div class="mb-0"><span class="font-xs color-grey-500">La Poste Gabonaise 2023. Tous droits
                                Réservés.</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="main">
        <section class="section d-block">
            <div class="box-swiper">
                <div class="swiper-container swiper-group-1 swiper-banner-1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="banner-1"
                                style="background-image:url({{ asset('front/imgs/page/homepage1/banner.png') }})">
                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12">
                                            <p class="font-md color-white mb-15 wow animate__animated animate__fadeIn"
                                                data-wow-delay=".0s">Poste aux lettres & Fret</p>
                                            <h1 class="color-white mb-25 wow animate__animated animate__fadeInUp"
                                                data-wow-delay=".0s">Opérateur postal universel <br
                                                    class="d-none d-lg-block">du Gabon</h1>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <p class="font-md color-white mb-20 wow animate__animated animate__fadeInUp"
                                                        data-wow-delay=".0s">Our experienced team of problem solvers
                                                        and a commitment to always align with our client’s business
                                                        goals and objectives is what drives mutual success.</p>
                                                </div>
                                            </div>
                                            <div class="box-button mt-30"><a
                                                    class="btn btn-brand-1-big hover-up mr-40 wow animate__animated animate__fadeInUp"
                                                    href="#">Faire une expédition</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="banner-1"
                                style="background-image:url({{ asset('front/imgs/page/homepage1/banner-2.png') }})">
                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12">
                                            <p class="font-md color-white mb-15 wow animate__animated animate__fadeIn"
                                                data-wow-delay=".0s">Poste aux lettres & Fret</p>
                                            <h1 class="color-white mb-25 wow animate__animated animate__fadeInUp"
                                                data-wow-delay=".0s">Opérateur postal universel <br
                                                    class="d-none d-lg-block">du Gabon</h1>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <p class="font-md color-white mb-20 wow animate__animated animate__fadeInUp"
                                                        data-wow-delay=".0s">Our experienced team of problem solvers
                                                        and a commitment to always align with our client’s business
                                                        goals and objectives is what drives mutual success.</p>
                                                </div>
                                            </div>
                                            <div class="box-button mt-30"><a
                                                    class="btn btn-brand-1-big hover-up mr-40 wow animate__animated animate__fadeInUp"
                                                    href="#">Faire une expédition</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination swiper-pagination-banner"></div>
                    </div>
                </div>
        </section>
        <div class="section bg-2 pt-65 pb-35">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 mb-30 text-center text-lg-start wow animate__animated animate__fadeIn">
                        <p class="font-2xl-bold color-brand-2">Nos <span class="color-brand-1"> Partenaires</span>
                        </p>
                    </div>
                    <div class="col-lg-9 mb-30">
                        <div class="box-swiper">
                            <div class="swiper-container swiper-group-6 pb-0">
                                <div class="swiper-wrapper wow animate__animated animate__fadeIn">
                                    <div class="swiper-slide"><img
                                            src="{{ asset('front/imgs/slider/logo/alea.png') }}" alt="transp">
                                    </div>
                                    <div class="swiper-slide"><img
                                            src="{{ asset('front/imgs/slider/logo/land.png') }}" alt="transp">
                                    </div>
                                    <div class="swiper-slide"><img
                                            src="{{ asset('front/imgs/slider/logo/logis.png') }}" alt="transp">
                                    </div>
                                    <div class="swiper-slide"><img
                                            src="{{ asset('front/imgs/slider/logo/truck.png') }}" alt="transp">
                                    </div>
                                    <div class="swiper-slide"><img
                                            src="{{ asset('front/imgs/slider/logo/saltos.png') }}" alt="transp">
                                    </div>
                                    <div class="swiper-slide"><img
                                            src="{{ asset('front/imgs/slider/logo/creati.png') }}" alt="transp">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="section mt-100">
            <div class="container">
                <h2 class="title-favicon mb-20 wow animate__animated animate__fadeIn">Ce que nous offrons</h2>
                <div class="row align-items-end">
                    <div class="col-lg-8 col-md-8 mb-30">
                        <p class="font-md color-gray-700 wow animate__animated animate__fadeIn">Welcome to our
                            tranporation services agency. We are the best at our trans-portation service ever.</p>
                    </div>

                </div>
                <div class="mt-20 box-background-offer">
                    <div class="bg-under"></div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 wow animate__animated animate__fadeIn">
                            <div class="card-offer hover-up">
                                <div class="card-image"><img
                                        src="{{ asset('front/imgs/page/homepage1/cargo-ship.png') }}" alt="transp">
                                </div>
                                <div class="card-info">
                                    <h5 class="color-brand-2 mb-15">Sea Forwarding</h5>
                                    <p class="font-sm color-grey-900 mb-35">We are professional in ocean freight with
                                        more than 12 years of experience and have shipped more than 100k shipments.</p>
                                    <div class="box-button-offer mb-30"><a
                                            class="btn btn-link font-sm color-brand-2">View Details<span>
                                                <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor"
                                                    viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg></span></a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 wow animate__animated animate__fadeIn">
                            <div class="card-offer hover-up">
                                <div class="card-image"><img src="{{ asset('front/imgs/page/homepage1/plane.png') }}"
                                        alt="transp"></div>
                                <div class="card-info">
                                    <h5 class="color-brand-2 mb-15">Air Freight Forwarding</h5>
                                    <p class="font-sm color-grey-900 mb-35">We are professional in ocean freight with
                                        more than 12 years of experience and have shipped more than 100k shipments.</p>
                                    <div class="box-button-offer mb-30"><a
                                            class="btn btn-link font-sm color-brand-2">View Details<span>
                                                <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor"
                                                    viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg></span></a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 wow animate__animated animate__fadeIn">
                            <div class="card-offer hover-up">
                                <div class="card-image"><img
                                        src="{{ asset('front/imgs/page/homepage1/delivery.png') }}" alt="transp">
                                </div>
                                <div class="card-info">
                                    <h5 class="color-brand-2 mb-15">Land Transportation</h5>
                                    <p class="font-sm color-grey-900 mb-35">We are professional in ocean freight with
                                        more than 12 years of experience and have shipped more than 100k shipments.</p>
                                    <div class="box-button-offer mb-30"><a
                                            class="btn btn-link font-sm color-brand-2">View Details<span>
                                                <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor"
                                                    viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg></span></a></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section class="section mt-85">
            <div class="container">
                <div class="text-center"><img class="mb-15" src="{{ asset('front/imgs/icon_bleu.png') }}"
                        alt="transp">
                    <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">Delivering Results for
                        Industry Leaders</p>
                    <h2 class="color-brand-2 mb-65 mt-15 wow animate__animated animate__fadeIn">Nous sommes fiers & <br
                            class="d-none d-lg-block">heureux de vous servir</h2>
                </div>
                <div class="row mt-50 align-items-center">
                    <div class="col-xl-7 col-lg-6 mb-30">
                        <div class="box-images-pround">
                            <div class="box-images wow animate__animated animate__fadeIn"><img class="img-main"
                                    src="{{ asset('front/imgs/page/homepage1/img1.png') }}" alt="transp">
                                <div class="image-2 shape-3"><img
                                        src="{{ asset('front/imgs/page/homepage1/icon1.png') }}" alt="transp">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 mb-30">
                        <div class="box-info-pround">
                            <h3 class="color-brand-2 mb-15 wow animate__animated animate__fadeIn">Fast shipping with
                                the most modern technology</h3>
                            <p class="font-md color-grey-500 wow animate__animated animate__fadeIn">Over the years, we
                                have worked together to expand our network of partners to deliver reliability and
                                consistency. We’ve also made significant strides to tightly integrate technology with
                                our processes, giving our clients greater visibility into every engagement.</p>
                            <div class="mt-30">
                                <ul class="list-ticks">
                                    <li class="wow animate__animated animate__fadeIn">
                                        <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor"
                                            viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>Task tracking
                                    </li>
                                    <li class="wow animate__animated animate__fadeIn">
                                        <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor"
                                            viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>Create task dependencies
                                    </li>
                                    <li class="wow animate__animated animate__fadeIn">
                                        <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor"
                                            viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>Task visualization
                                    </li>
                                    <li class="wow animate__animated animate__fadeIn">
                                        <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor"
                                            viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>hare files, discuss
                                    </li>
                                    <li class="wow animate__animated animate__fadeIn">
                                        <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor"
                                            viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>Meet deadlines faster
                                    </li>
                                    <li class="wow animate__animated animate__fadeIn">
                                        <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor"
                                            viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>Track time spent on each project
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-30 text-start d-flex wow animate__animated animate__fadeIn"><a
                                    class="hover-up mr-10" href="#"><img
                                        src="{{ asset('front/imgs/template/appstore-btn.png') }}"
                                        alt="transp"></a><a class="hover-up" href="#"><img
                                        src="{{ asset('front/imgs/template/google-play-btn.png') }}"
                                        alt="transp"></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section mt-55 bg-1 position-relative pt-90 pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6"><span class="btn btn-tag wow animate__animated animate__fadeIn">Get in
                            touch</span>
                        <h3 class="color-grey-900 mb-20 mt-15 wow animate__animated animate__fadeIn">Proud to
                            Deliver<br class="d-none d-lg-block">Excellence Every Time</h3>
                        <p class="font-md color-grey-900 mb-40 wow animate__animated animate__fadeIn">Excepteur sint
                            occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit laborum — semper
                            quis lectus nulla. Interactively transform magnetic growth strategies whereas prospective
                            "outside the box" thinking.</p>
                        <div class="row">
                            <div class="col-lg-6 mb-30">
                                <h6
                                    class="chart-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">
                                    Boost your sale</h6>
                                <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">The latest
                                    design trends meet hand-crafted templates.</p>
                            </div>
                            <div class="col-lg-6 mb-30">
                                <h6
                                    class="feature-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">
                                    Introducing New Features</h6>
                                <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">The latest
                                    design trends meet hand-crafted templates.</p>
                            </div>
                        </div>
                        <div class="mt-20"><a class="btn btn-brand-2 mr-20 wow animate__animated animate__fadeIn"
                                href="contact.html">Contact Us</a><a
                                class="btn btn-link-medium wow animate__animated animate__fadeIn" href="#">Learn
                                More
                                <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor"
                                    viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg></a></div>
                    </div>
                </div>
            </div>
            <div class="box-image-touch"></div>
        </section>
        <section class="section pt-85 bg-worldmap">
            <div class="container">
                <div class="text-center"><img class="mb-15" src="{{ asset('front/imgs/icon_bleu.png') }}"
                        alt="transp">
                    <h2 class="color-brand-2 mb-20 wow animate__animated animate__fadeIn">Comment ça marche</h2>
                    <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">You choose the cities where
                        you’d like to deliver. All deliveries are within a specific service area and delivery services
                        vary by location. Whatever the mode or requirement, we will find and book the ideal expedited
                        shipping solution to ensure a timely delivery.</p>
                </div>
                <div class="row mt-50">
                    <div class="col-lg-6 mb-30">
                        <div class="box-image-how"><img class="w-100 wow animate__animated animate__fadeIn"
                                src="{{ asset('front/imgs/page/homepage1/how-it-work.png') }}" alt="transp">
                            <div class="box-info-bottom-img">
                                <div class="image-play"><img class="mb-15 wow animate__animated animate__fadeIn"
                                        src="{{ asset('front/imgs/template/icons/play.svg') }}" alt="transp"></div>
                                <div class="info-play">
                                    <h4 class="color-white mb-15 wow animate__animated animate__fadeIn">We have 25
                                        years experience in this passion</h4>
                                    <p class="font-sm color-white wow animate__animated animate__fadeIn">There are many
                                        variations of passages of Lorem Ipsum available, but the majority have suffered
                                        alteration in some form, by injected humour</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-30">
                        <ul class="list-how-works">
                            <li>
                                <div class="image-how"><span class="img"><img
                                            src="{{ asset('front/imgs/page/homepage1/order.png') }}"
                                            alt="transp"></span></div>
                                <div class="info-how">
                                    <h5 class="color-brand-2 wow animate__animated animate__fadeIn">Customer places
                                        order</h5>
                                    <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">Inspection
                                        and quality check of goods</p>
                                </div>
                            </li>
                            <li>
                                <div class="image-how"><span class="img"><img
                                            src="{{ asset('front/imgs/page/homepage1/payment.png') }}"
                                            alt="transp"></span></div>
                                <div class="info-how">
                                    <h5 class="color-brand-2 wow animate__animated animate__fadeIn">Payment successful
                                    </h5>
                                    <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">Payoneer,
                                        Paypal, or Visa master card</p>
                                </div>
                            </li>
                            <li>
                                <div class="image-how"><span class="img"><img
                                            src="{{ asset('front/imgs/page/homepage1/warehouse.png') }}"
                                            alt="transp"></span>
                                </div>
                                <div class="info-how">
                                    <h5 class="color-brand-2 wow animate__animated animate__fadeIn">Warehouse receives
                                        order</h5>
                                    <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">Check the
                                        accuracy of the goods.</p>
                                </div>
                            </li>
                            <li>
                                <div class="image-how"><span class="img"><img
                                            src="{{ asset('front/imgs/page/homepage1/picked.png') }}"
                                            alt="transp"></span></div>
                                <div class="info-how">
                                    <h5 class="color-brand-2 wow animate__animated animate__fadeIn">Item picked, packed
                                        & shipped</h5>
                                    <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">Ship the
                                        goods to a local carrier</p>
                                </div>
                            </li>
                            <li>
                                <div class="image-how"><span class="img"><img
                                            src="{{ asset('front/imgs/page/homepage1/delivery.png') }}"
                                            alt="transp"></span></div>
                                <div class="info-how">
                                    <h5 class="color-brand-2 wow animate__animated animate__fadeIn">Delivered & Measure
                                        success</h5>
                                    <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">Update
                                        order status on the system</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="section mt-50 bg-customers-say">
            <div class="container">
                <h2 class="title-favicon color-white mb-20 title-padding-left wow animate__animated animate__fadeIn">
                    Ce que nos clients disent </h2>
                <p class="font-lg color-white pl-55 wow animate__animated animate__fadeIn">Hear from our users who have
                    saved thousands on their<br class="d-none d-lg-block">Startup and SaaS solution spend.</p>
            </div>
            <div class="box-slide-customers mt-50">
                <div class="box-swiper">
                    <div class="swiper-container swiper-group-3-customers pb-50">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide wow animate__animated animate__fadeIn">
                                <div class="card-testimonial-grid">
                                    <div class="box-author mb-25"><a href="#"><img
                                                src="{{ asset('front/imgs/page/homepage1/author.png') }}"
                                                alt="transp"></a>
                                        <div class="author-info"><a href="#"><span
                                                    class="font-xl-bold color-brand-2 author-name">Guy
                                                    Hawkins</span></a><span
                                                class="font-sm color-grey-500 department">Bank of America</span></div>
                                    </div>
                                    <p class="font-md color-grey-700">Access the same project through five different
                                        dynamic views: a kanban board, Gantt chart, spreadsheet, calendar or simple task
                                        list.</p>
                                    <div class="card-bottom-info justify-content-between">
                                        <div class="rating text-start"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><br><span class="font-sm color-white">For customer
                                                support</span></div><span
                                            class="font-xs color-grey-500 rate-post text-end">Rate: 4.95 / 5</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide wow animate__animated animate__fadeIn">
                                <div class="card-testimonial-grid">
                                    <div class="box-author mb-25"><a href="#"><img
                                                src="{{ asset('front/imgs/page/homepage1/author2.png') }}"
                                                alt="transp"></a>
                                        <div class="author-info"><a href="#"><span
                                                    class="font-xl-bold color-brand-2 author-name">Eleanor
                                                    Pena</span></a><span class="font-sm color-grey-500 department">Bank
                                                of America</span></div>
                                    </div>
                                    <p class="font-md color-grey-700">Access the same project through five different
                                        dynamic views: a kanban board, Gantt chart, spreadsheet, calendar or simple task
                                        list.</p>
                                    <div class="card-bottom-info justify-content-between">
                                        <div class="rating text-start"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><br><span class="font-sm color-white">For customer
                                                support</span></div><span
                                            class="font-xs color-grey-500 rate-post text-end">Rate: 4.95 / 5</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide wow animate__animated animate__fadeIn">
                                <div class="card-testimonial-grid">
                                    <div class="box-author mb-25"><a href="#"><img
                                                src="{{ asset('front/imgs/page/homepage1/author3.png') }}"
                                                alt="transp"></a>
                                        <div class="author-info"><a href="#"><span
                                                    class="font-xl-bold color-brand-2 author-name">Cody
                                                    Fisher</span></a><span
                                                class="font-sm color-grey-500 department">Bank of America</span></div>
                                    </div>
                                    <p class="font-md color-grey-700">Access the same project through five different
                                        dynamic views: a kanban board, Gantt chart, spreadsheet, calendar or simple task
                                        list.</p>
                                    <div class="card-bottom-info justify-content-between">
                                        <div class="rating text-start"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><img
                                                src="{{ asset('front/imgs/template/icons/star.svg') }}"
                                                alt="transp"><br><span class="font-sm color-white">For customer
                                                support</span></div><span
                                            class="font-xs color-grey-500 rate-post text-end">Rate: 4.95 / 5</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-pagination-customers">
                            <div
                                class="swiper-button-prev swiper-button-prev-customers swiper-button-prev-style-1 wow animate__animated animate__fadeIn">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                                </svg>
                            </div>
                            <div
                                class="swiper-button-next swiper-button-next-customers swiper-button-next-style-1 wow animate__animated animate__fadeIn">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section pt-95 bg-get-quote">
            <div class="container">
                <div class="text-center mb-45">
                    <h2 class="color-brand-1 mb-15 wow animate__animated animate__fadeIn">World’s Leading Companies<br
                            class="d-none d-lg-block">For Over 80 Years.</h2>
                    <p class="font-md color-white wow animate__animated animate__fadeIn">A big opportunity for your
                        business growth. Delivering Results for Industry Leaders. We are<br
                            class="d-none d-lg-block">proud of our workfor and have worked hard.</p>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-30">
                        <div class="cardLeadingCompany">
                            <div class="cardImage"><span class="img wow animate__animated animate__fadeIn"><img
                                        src="{{ asset('front/imgs/page/homepage1/handover.png') }}"
                                        alt="transp"></span></div>
                            <div class="cardInfo">
                                <h3 class="color-brand-1 wow animate__animated animate__fadeIn"><span>+</span><span
                                        class="count">38</span><span>0,000</span></h3>
                                <p class="font-lg color-white wow animate__animated animate__fadeIn">Parcels Shipped
                                    Safely</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-30">
                        <div class="cardLeadingCompany">
                            <div class="cardImage"><span class="img"><img
                                        src="{{ asset('front/imgs/page/homepage1/cities.png') }}"
                                        alt="transp"></span></div>
                            <div class="cardInfo">
                                <h3 class="color-brand-1 wow animate__animated animate__fadeIn"><span>+</span><span
                                        class="count">12</span><span>0,000</span></h3>
                                <p class="font-lg color-white wow animate__animated animate__fadeIn">Cities Served
                                    Worldwide</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-30">
                        <div class="cardLeadingCompany">
                            <div class="cardImage"><span class="img"><img
                                        src="{{ asset('front/imgs/page/homepage1/client.png') }}"
                                        alt="transp"></span></div>
                            <div class="cardInfo">
                                <h3 class="color-brand-1 wow animate__animated animate__fadeIn"><span>+</span><span
                                        class="count">228</span><span>0</span></h3>
                                <p class="font-lg color-white wow animate__animated animate__fadeIn">Satisfied Clients
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-30">
                        <div class="cardLeadingCompany">
                            <div class="cardImage"><span class="img"><img
                                        src="{{ asset('front/imgs/page/homepage1/company.png') }}"
                                        alt="transp"></span></div>
                            <div class="cardInfo">
                                <h3 class="color-brand-1 wow animate__animated animate__fadeIn"><span>+</span><span
                                        class="count">12</span><span>000</span></h3>
                                <p class="font-lg color-white wow animate__animated animate__fadeIn">Company We Help
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="section pt-80 mb-70 bg-faqs">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="box-faqs-left">
                            <h2 class="title-favicon mb-20 wow animate__animated animate__fadeIn">Foire Aux Questions
                            </h2>
                            <p class="font-md color-grey-700 mb-50 wow animate__animated animate__fadeIn">Feeling
                                inquisitive? Have a read through some of our FAQs or contact our supporters for help</p>
                            <div class="box-gallery-faqs">
                                <div class="image-top"><img
                                        src="{{ asset('front/imgs/page/homepage1/img-faq1.png') }}" alt="transp">
                                </div>
                                <div class="image-bottom">
                                    <div class="image-faq-1"><img
                                            src="{{ asset('front/imgs/page/homepage1/img-faq2.png') }}"
                                            alt="transp"></div>
                                    <div class="image-faq-2"><img
                                            src="{{ asset('front/imgs/page/homepage1/img-faq3.png') }}"
                                            alt="transp"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="box-accordion">
                            <div class="accordion" id="accordionFAQ">
                                <div class="accordion-item wow animate__animated animate__fadeIn">
                                    <h5 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button text-heading-5" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">How can I return an
                                            item purchased online?</button>
                                    </h5>
                                    <div class="accordion-collapse collapse show" id="collapseTwo"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionFAQ">
                                        <div class="accordion-body">Contrary to popular belief, Lorem Ipsum is not
                                            simply random text. It has roots in a piece of classical Latin literature Id
                                            pro doctus mediocrem erroribus, diam nostro sed cu. Ea pri graeco tritani
                                            partiendo. Omittantur No tale choro fastidii his, pri cu epicuri perpetua.
                                            Enim dictas omittantur et duo, vocent lucilius quaestio mea ex. Ex illum
                                            officiis id.</div>
                                    </div>
                                </div>
                                <div class="accordion-item wow animate__animated animate__fadeIn">
                                    <h5 class="accordion-header" id="headingThree">
                                        <button class="accordion-button text-heading-5 collapsed text-heading-5 type="
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree">Can I cancel or
                                            change my order?</button>
                                    </h5>
                                    <div class="accordion-collapse collapse" id="collapseThree"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionFAQ">
                                        <div class="accordion-body">Aut architecto consequatur sit error nemo sed
                                            dolorum suscipit 33 impedit dignissimos ut velit blanditiis qui quos magni
                                            id dolore dignissimos. Sit ipsa consectetur et sint harum et dicta
                                            consequuntur id cupiditate perferendis qui quisquam enim. Vel autem illo id
                                            error excepturi est dolorum voluptas qui maxime consequatur et culpa
                                            quibusdam in iusto vero sit amet Quis.</div>
                                    </div>
                                </div>
                                <div class="accordion-item wow animate__animated animate__fadeIn">
                                    <h5 class="accordion-header" id="headingFour">
                                        <button class="accordion-button text-heading-5 collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                            aria-expanded="false" aria-controls="collapseFour">I have promotional or
                                            discount code?</button>
                                    </h5>
                                    <div class="accordion-collapse collapse" id="collapseFour"
                                        aria-labelledby="headingFour" data-bs-parent="#accordionFAQ">
                                        <div class="accordion-body">Eos nostrum aperiam ab enim quas sit voluptate
                                            fuga. Ea aperiam voluptas a accusantium similique 33 alias sapiente non
                                            vitae repellat et dolorum omnis eos beatae praesentium id sunt corporis. Aut
                                            nisi blanditiis aut corrupti quae et accusantium doloribus sed tempore
                                            libero a dolorum beatae.</div>
                                    </div>
                                </div>
                                <div class="accordion-item wow animate__animated animate__fadeIn">
                                    <h5 class="accordion-header" id="headingFive">
                                        <button class="accordion-button text-heading-5 collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                            aria-expanded="false" aria-controls="collapseFive">What are the delivery
                                            types you use?</button>
                                    </h5>
                                    <div class="accordion-collapse collapse" id="collapseFive"
                                        aria-labelledby="headingFive" data-bs-parent="#accordionFAQ">
                                        <div class="accordion-body">Et beatae quae ex minima porro aut nihil quia sed
                                            optio dignissimos et voluptates deleniti et nesciunt veritatis et suscipit
                                            quod. Est sint voluptate id unde nesciunt non deleniti debitis. Ut dolores
                                            tempore vel placeat nemo quo enim reprehenderit eos corrupti maiores et
                                            minima quaerat. Quo sequi eaque eum similique sint et autem perspiciatis cum
                                            Quis exercitationem quo quos excepturi non ducimus ducimus eos natus velit.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item wow animate__animated animate__fadeIn">
                                    <h5 class="accordion-header" id="headingSix">
                                        <button class="accordion-button text-heading-5 collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSix"
                                            aria-expanded="false" aria-controls="collapseSix">How can I pay for my
                                            purchases?</button>
                                    </h5>
                                    <div class="accordion-collapse collapse" id="collapseSix"
                                        aria-labelledby="headingSix" data-bs-parent="#accordionFAQ">
                                        <div class="accordion-body">Qui quas itaque ut molestias culpa vel culpa
                                            voluptas eos fugit sint ex veritatis totam cum unde maxime! Qui eius fugiat
                                            qui veritatis cumque a nesciunt nemo. Id numquam rerum est molestiae quia ut
                                            nisi architecto a officiis itaque eum quod repellat ut dolorem dolorem aut
                                            ipsam ipsa.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="line-border mt-50 mb-50"></div>
                            <h3 class="color-brand-2 wow animate__animated animate__fadeIn">Nead more help?</h3>
                            <div class="mt-20"><a
                                    class="btn btn-brand-1-big mr-20 wow animate__animated animate__fadeIn"
                                    href="contact.html">Contact Us</a><a
                                    class="btn btn-link-medium wow animate__animated animate__fadeIn"
                                    href="#">Learn More
                                    <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor"
                                        viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div class="section bg-map d-block">
            <div class="container">
                <div class="box-map">
                    <iframe class="wow animate__animated animate__fadeIn"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3179.960389549842!2d-83.76408938441998!3d37.15364135542302!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x884352a00e70879f%3A0x1ad06ed33b7003c!2sIangar!5e0!3m2!1svi!2s!4v1678013229780!5m2!1svi!2s"
                        height="420" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <div class="map-info"><img class="mb-25 wow animate__animated animate__fadeIn"
                            src="{{ asset('front/imgs/laposte.png') }}" alt="poste">
                        <p class="color-grey-700 mb-25 wow animate__animated animate__fadeIn">4517 Washington Ave.
                            Manchester, Kentucky 39495</p>
                        <p class="color-grey-700 mb-10 wow animate__animated animate__fadeIn">
                            <svg class="icon-16 mr-10 color-brand-1" fill="none" stroke="currentColor"
                                stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z">
                                </path>
                            </svg>Phone: +01-246-357 (Any time 24/7)
                        </p>
                        <p class="color-grey-700 mb-30 wow animate__animated animate__fadeIn">
                            <svg class="icon-16 mr-10 color-brand-1" fill="none" stroke="currentColor"
                                stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75">
                                </path>
                            </svg>Email: contact@transp.eu.com
                        </p>
                        <div class="line-border mb-25 wow animate__animated animate__fadeIn"></div>
                        <p class="color-grey-700 font-md-bold wow animate__animated animate__fadeIn">Hours: 8:00 -
                            17:00, Mon - Sat</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="footer">
        <div class="footer-1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 width-23 mb-30">
                        <div class="mb-20"><img src="{{ asset('front/imgs/laposte-white.png') }}" alt="poste">
                        </div>
                        <p class="font-xs mb-20 color-white">We fuse our global network with our depth of expertise in
                            air freight, ocean freight, railway transportation, trucking, and multimode transportation,
                            also we are providing sourcing, warehousing, E-commercial fulfillment, and value-added
                            service to our customers including kitting, assembly, customized package and business
                            inserts, etc.</p>
                        <h6 class="color-brand-1">Follow Us</h6>
                        <div class="mt-15"><a class="icon-socials icon-facebook" href="#"></a><a
                                class="icon-socials icon-instagram" href="#"></a><a
                                class="icon-socials icon-twitter" href="#"></a><a
                                class="icon-socials icon-youtube" href="#"></a><a
                                class="icon-socials icon-skype" href="#"></a></div>
                    </div>
                    <div class="col-lg-3 width-16 mb-30">
                        <h5 class="mb-10 color-brand-1">Company</h5>
                        <ul class="menu-footer">
                            <li><a href="about.html">Mission &amp; Vision</a></li>
                            <li><a href="team.html">Our Team</a></li>
                            <li><a href="career.html">Careers</a></li>
                            <li><a href="#">Press &amp; Media</a></li>
                            <li><a href="#">Advertising</a></li>
                            <li><a href="#">Testimonials</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 width-16 mb-30">
                        <h5 class="mb-10 color-brand-1">Industries</h5>
                        <ul class="menu-footer">
                            <li><a href="#">Global coverage</a></li>
                            <li><a href="#">Distribution</a></li>
                            <li><a href="#">Accounting Tools</a></li>
                            <li><a href="#">Freight Recovery</a></li>
                            <li><a href="#">Supply Chain</a></li>
                            <li><a href="#">Warehousing</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 width-16 mb-30">
                        <h5 class="mb-10 color-brand-1">Services</h5>
                        <ul class="menu-footer">
                            <li><a href="#">Air Freight</a></li>
                            <li><a href="#">Ocean Freight</a></li>
                            <li><a href="#">Railway Freight</a></li>
                            <li><a href="#">Warehousing</a></li>
                            <li><a href="#">Distribution</a></li>
                            <li><a href="#">Value added</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 width-20 mb-30">
                        <h5 class="mb-10 color-brand-1">Gallery</h5>
                        <div class="galleries-footer">
                            <ul class="list-imgs">
                                <li> <img src="{{ asset('front/imgs/page/homepage1/gal1.png') }}" alt="transp">
                                </li>
                                <li> <img src="{{ asset('front/imgs/page/homepage1/gal2.png') }}" alt="transp">
                                </li>
                                <li> <img src="{{ asset('front/imgs/page/homepage1/gal3.png') }}" alt="transp">
                                </li>
                                <li> <img src="{{ asset('front/imgs/page/homepage1/gal4.png') }}" alt="transp">
                                </li>
                                <li> <img src="{{ asset('front/imgs/page/homepage1/gal5.png') }}" alt="transp">
                                </li>
                                <li> <img src="{{ asset('front/imgs/page/homepage1/gal6.png') }}" alt="transp">
                                </li>
                                <li> <img src="{{ asset('front/imgs/page/homepage1/gal7.png') }}" alt="transp">
                                </li>
                                <li> <img src="{{ asset('front/imgs/page/homepage1/gal8.png') }}" alt="transp">
                                </li>
                                <li> <img src="{{ asset('front/imgs/page/homepage1/gal9.png') }}" alt="transp">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-2">
            <div class="container">
                <div class="footer-bottom">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12 text-center text-lg-start"><span
                                class="color-grey-300 font-md">La Poste Gabonaise 2023. Tous droits réservés.</span>
                        </div>
                        <div class="col-lg-6 col-md-12 text-center text-lg-end">
                            <ul class="menu-bottom">
                                <li><a class="font-sm color-grey-300" href="t#">PC</a>
                                </li>
                                <li><a class="font-sm color-grey-300" href="#">Cookies</a></li>
                                <li><a class="font-sm color-grey-300" href="#">TCU</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('front/js/vendors/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front/js/vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front/js/vendors/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('front/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('front/js/vendors/waypoints.js') }}"></script>
    <script src="{{ asset('front/js/vendors/wow.js') }}"></script>
    <script src="{{ asset('front/js/vendors/magnific-popup.js') }}"></script>
    <script src="{{ asset('front/js/vendors/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('front/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('front/js/vendors/isotope.js') }}"></script>
    <script src="{{ asset('front/js/vendors/scrollup.js') }}"></script>
    <script src="{{ asset('front/js/vendors/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('front/js/vendors/noUISlider.js') }}"></script>
    <script src="{{ asset('front/js/vendors/slider.js') }}"></script>
    <!-- Count down-->
    <script src="{{ asset('front/js/vendors/counterup.js') }}"></script>
    <script src="{{ asset('front/js/vendors/jquery.countdown.min.js') }}"></script>
    <!-- Count down-->
    <script src="{{ asset('front/js/vendors/jquery.elevatezoom.js') }}"></script>
    <script src="{{ asset('front/js/vendors/slick.js') }}"></script>
    <script src="{{ asset('front/js/main28b5.js?v=2.0.0') }}"></script>
</body>

</html>
