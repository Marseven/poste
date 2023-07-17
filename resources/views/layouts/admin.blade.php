<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="Découvrez les différentes
        spécificités d'envoi d'un colis au Gabon : Délais indicatifs
        de livraison, formalités douaniéres, restrictions particuliéres" />

    <link href="{{ URL::to('assets/dist/images/logos/icon_bleu.png') }}" rel="shortcut icon">

    <!-- A propos du Dev -->
    <meta name="auteur" content="JOBS">

    <title>{{ $app_name ? $app_name : 'LA POSTE' }} | {{ $page_title ? $page_title : '' }}</title>


    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ URL::to('assets/dist/css/app.css') }}" />

    @stack('styles')
    {{-- jaune #ffc928 --}}
    <!-- END: CSS Assets-->



</head>
<!-- END: Head -->

<body class="py-5">
    <div class="flex mt-[4.7rem] md:mt-0">
        <!-- BEGIN: Side Menu -->
        <nav class="side-nav">
            <a href="" class="intro-x flex items-center pl-5 pt-4">
                <img alt="La Poste" class="w-6" src="{{ URL::to('assets/dist/images/logos/icon_blanc.png') }}">
                <span class="hidden xl:block text-white text-lg ml-3 font-extrabold"> LA POSTE </span>
            </a>
            <div class="side-nav__devider my-6"></div>
            <ul>

                <li>
                    <a href="{{ route('adminHome') }}" class="side-menu side-menu{{ $home ?? '' }}">
                        <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                        <div class="side-menu__title">
                            Tableau de bord
                        </div>
                    </a>
                </li>



                <li>
                    <a href="javascript:;" class="side-menu {{ $exp ?? '' }}">
                        <div class="side-menu__icon"> <i data-lucide="truck"></i> </div>
                        <div class="side-menu__title">
                            Expéditions
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ $exp_sub ?? '' }}">
                        <li>
                            <a href="{{ route('adminNewExpedition') }}" class="side-menu {{ $exp1 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Nouvelle expédition </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminExpeditionList') }}" class="side-menu {{ $exp2 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Liste des expéditions </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminPackage') }}" class="side-menu {{ $exp3 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Liste des packages </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="side-nav__devider my-6"></li>

                <li>
                    <a href="javascript:;" class="side-menu {{ $transaction ?? '' }}">
                        <div class="side-menu__icon"> <i data-lucide="credit-card"></i> </div>
                        <div class="side-menu__title">
                            Transactions
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ $transaction_sub ?? '' }}">
                        <li>
                            <a href="#" class="side-menu{{ $transaction1 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Liste des paiements </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="side-menu{{ $transaction2 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Liste des factures </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" class="side-menu {{ $place ?? '' }}">
                        <div class="side-menu__icon"> <i data-lucide="map-pin"></i> </div>
                        <div class="side-menu__title">
                            Emplacements
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ $place_sub ?? '' }}">
                        <li>
                            <a href="{{ route('adminPays') }}" class="side-menu {{ $place1 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Pays </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminProvince') }}" class="side-menu {{ $place2 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Provinces </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminVille') }}" class="side-menu {{ $place3 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Villes </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminAgence') }}" class="side-menu {{ $place4 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title">Agences</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="side-nav__devider my-6"></li>

                <li>
                    <a href="javascript:;" class="side-menu {{ $account ?? '' }}">
                        <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                        <div class="side-menu__title">
                            Comptes
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ $account_sub ?? '' }}">
                        <li>
                            <a href="{{ route('adminNewCompte') }}" class="side-menu {{ $account1 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Nouveau Compte </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminCompte') }}" class="side-menu {{ $account2 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Liste des Comptes </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" class="side-menu {{ $setting ?? '' }}">
                        <div class="side-menu__icon"> <i data-lucide="hard-drive"></i> </div>
                        <div class="side-menu__title">
                            Paramètres
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ $setting_sub ?? '' }}">

                        <li>
                            <a href="javascript:;" class="side-menu {{ $setting1 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="hard-drive"></i> </div>
                                <div class="side-menu__title">
                                    Configuration
                                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                                </div>
                            </a>
                            <ul class="{{ $setting_sub1 ?? '' }}">
                                <li>
                                    <a href="" class="side-menu {{ $setting11 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">General</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="side-menu {{ $setting12 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">SMS</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="side-menu {{ $setting13 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Whatsapp</div>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:;" class="side-menu {{ $setting2 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="dollar-sign"></i> </div>
                                <div class="side-menu__title">
                                    Paiements
                                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                                </div>
                            </a>
                            <ul class="{{ $setting_sub2 ?? '' }}">
                                <li>
                                    <a href="" class="side-menu {{ $setting21 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Méthodes de paiement</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="side-menu {{ $setting22 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Modes de paiement</div>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:;" class="side-menu {{ $setting3 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="plus"></i> </div>
                                <div class="side-menu__title">
                                    Suppléments
                                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                                </div>
                            </a>
                            <ul class="{{ $setting_sub3 ?? '' }}">
                                <li>
                                    <a href="{{ route('adminSociete') }}" class="side-menu {{ $setting31 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                                        <div class="side-menu__title">Société</div>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:;" class="side-menu {{ $setting4 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="send"></i> </div>
                                <div class="side-menu__title">
                                    Expéditions
                                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                                </div>
                            </a>
                            <ul class="{{ $setting_sub4 ?? '' }}">
                                <li>
                                    <a href="{{ route('adminService') }}" class="side-menu {{ $setting41 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Services</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('adminStatut') }}" class="side-menu {{ $setting42 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Statuts</div>
                                    </a>
                                </li>

                                {{-- <li>
                                    <a href="{{ route('adminTarif') }}" class="side-menu">
                                        <div class="side-menu__icon"> <i data-lucide="tag"></i> </div>
                                        <div class="side-menu__title">Tarifs</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('adminForfait') }}" class="side-menu">
                                        <div class="side-menu__icon"> <i data-lucide="target"></i> </div>
                                        <div class="side-menu__title">Plage de poids</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('adminDelai') }}" class="side-menu">
                                        <div class="side-menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="side-menu__title">Delais d'expédition</div>
                                    </a>
                                </li> --}}


                                <li>
                                    <a href="{{ route('adminType') }}" class="side-menu {{ $setting43 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Types d'expédition</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('adminRegime') }}" class="side-menu {{ $setting44 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Régimes d'expédition</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('adminCategory') }}" class="side-menu {{ $setting45 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Catégories d'expédition</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('adminPrice') }}" class="side-menu {{ $setting46 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Tarif d'expédition</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('adminMouchard') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="command"></i> </div>
                        <div class="side-menu__title">
                            Log
                            <div class="side-menu__sub-icon "> </div>
                        </div>
                    </a>
                </li>

                <li class="side-nav__devider my-6"></li>

                {{-- <li>
                    <a href="" class="side-menu"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="side-menu__icon"> <i data-lucide="log-out"></i> </div>
                        <div class="side-menu__title"> Déconnexion </div>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li> --}}


            </ul>
        </nav>
        <!-- END: Side Menu -->

        <!-- BEGIN: Content -->
        <div class="content">

            <!-- BEGIN: Top Bar -->
            <div class="top-bar">
                <!-- BEGIN: Breadcrumb -->
                <nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('adminHome') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $page_title ? $page_title : 'Tableau de bord' }}
                        </li>
                    </ol>
                </nav>
                <!-- END: Breadcrumb -->

                <!-- BEGIN: Notifications -->
                <div class="intro-x dropdown mr-auto sm:mr-6">
                    <div class="dropdown-toggle notification notification--bullet cursor-pointer" role="button"
                        aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="bell"
                            class="notification__icon dark:text-slate-500"></i> </div>
                    <div class="notification-content pt-2 dropdown-menu">
                        <div class="notification-content__box dropdown-content">
                            <div class="notification-content__title">Notifications</div>



                            <div class="cursor-pointer relative flex items-center mt-5">
                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                    <img alt="Midone - HTML Admin Template" class="rounded-full"
                                        src="{{ URL::to('assets/dist/images/profile-2.jpg') }}">
                                    <div
                                        class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white dark:border-darkmode-600">
                                    </div>
                                </div>
                                <div class="ml-2 overflow-hidden">
                                    <div class="flex items-center">
                                        <a href="javascript:;" class="font-medium truncate mr-5">Johnny Depp</a>
                                        <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">01:10 PM</div>
                                    </div>
                                    <div class="w-full truncate text-slate-500 mt-0.5">Contrary to popular belief,
                                        Lorem Ipsum is not simply random text. It has roots in a piece of classical
                                        Latin literature from 45 BC, making it over 20</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- END: Notifications -->

                <!-- BEGIN: Account Menu -->
                <div class="intro-x dropdown w-8 h-8">
                    <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in"
                        role="button" aria-expanded="false" data-tw-toggle="dropdown">
                        <img alt="{{ Auth::user()->name }}" src="{{ Auth::user()->avatar }}">
                    </div>
                    <div class="dropdown-menu w-56">
                        <ul class="dropdown-content bg-primary text-white">
                            <li class="p-2">
                                <div class="font-medium">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">
                                    {{ Auth::user()->role }}
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider border-white/[0.08]">
                            </li>
                            <li>
                                <a href="{{ route('adminProfil') }}" class="dropdown-item hover:bg-white/5"> <i
                                        data-lucide="user" class="w-4 h-4 mr-2"></i> Mon Compte </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider border-white/[0.08]">
                            </li>
                            <li>
                                <a href="" class="dropdown-item hover:bg-white/5"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Déconnexion </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END: Account Menu -->
            </div>
            <!-- END: Top Bar -->
            <div class="col-span-12 2xl:col-span-12">
                @if (Session::get('success'))
                    <div class="alert alert-success alert-dismissible show flex items-center mb-2" role="alert"
                        id="alert"> <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i>
                        <strong>Succès!</strong> {{ Session::get('success') }}. <button type="button"
                            class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i
                                data-lucide="x" class="w-4 h-4"></i> </button>
                    </div>
                    <br>
                @endif

                @if (Session::get('failed'))
                    <div class="alert alert-danger alert-dismissible show flex items-center mb-2" role="alert"
                        id="alert"> <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i> <strong>Attention !
                        </strong> {{ Session::get('failed') }}. <button type="button" class="btn-close text-white"
                            data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i>
                        </button> </div>
                    <br>
                @endif
                @yield('page-content')
            </div>
        </div>
        <!-- END: Content -->

    </div>

    <!-- BEGIN: JS Assets-->
    <script src="{{ URL::to('assets/dist/js/app.js') }}"></script>

    <!--end::Custom Javascript-->
    @stack('scripts')
    <!--end::Javascript-->
</body>

</html>
