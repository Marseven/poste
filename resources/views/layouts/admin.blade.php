<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<!-- BEGIN: Head -->

@php
    $user = Auth::user();
@endphp

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
    <!-- BEGIN: Mobile Menu -->
    <div class="mobile-menu md:hidden">
        <div class="mobile-menu-bar">
            <a href="" class="flex mr-auto">
                <img alt="Midone - HTML Admin Template" class="w-6"
                    src="{{ URL::to('assets/dist/images/logos/icon_blanc.png') }}">
            </a>
            <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2"
                    class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        </div>
        <div class="scrollable">
            <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle"
                    class="w-8 h-8 text-white transform -rotate-90"></i> </a>
            <ul class="scrollable__content py-2">

                <li>
                    <a href="{{ route('adminHome') }}" class="menu">
                        <div class="menu__icon"> <i data-lucide="home"></i> </div>
                        <div class="menu__title">
                            Tableau de bord
                        </div>
                    </a>
                </li>

                <li>
                    <a href="javascript:;" class="menu {{ $exp ?? '' }}">
                        <div class="menu__icon"> <i data-lucide="truck"></i> </div>
                        <div class="menu__title">
                            Expéditions
                            <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ $exp_sub ?? '' }}">
                        <li>
                            <a href="{{ route('adminNewExpedition') }}" class="menu {{ $exp1 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Nouvelle expédition </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminExpeditionList') }}" class="menu {{ $exp2 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Liste des expéditions </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminPackage') }}" class="menu {{ $exp3 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Liste des Dépêches </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminReservationList') }}" class="menu {{ $exp4 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Liste des Réservations </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav__devider my-6"></li>

                <li>
                    <a href="javascript:;" class="menu {{ $place ?? '' }}">
                        <div class="menu__icon"> <i data-lucide="map-pin"></i> </div>
                        <div class="menu__title">
                            Bureaux de Poste
                            <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ $place_sub ?? '' }}">
                        <li>
                            <a href="{{ route('adminReseaux') }}" class="menu {{ $place1 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Réseaux </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminZones') }}" class="menu {{ $place2 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Zones </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminPays') }}" class="menu {{ $place3 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Pays </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminProvince') }}" class="menu {{ $place4 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Provinces </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminVille') }}" class="menu {{ $place5 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Villes </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminAgence') }}" class="menu {{ $place6 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="menu__title">Bureaux de Poste</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" class="menu {{ $transaction ?? '' }}">
                        <div class="menu__icon"> <i data-lucide="credit-card"></i> </div>
                        <div class="menu__title">
                            Transactions
                            <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ $transaction_sub ?? '' }}">
                        <li>
                            <a href="{{ route('adminPaiement') }}" class="menu {{ $transaction1 ?? '' }}">
                                <div class="menu__icon"><i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Liste des paiements </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" class="menu {{ $reclamation ?? '' }}">
                        <div class="menu__icon"> <i data-lucide="message-square"></i> </div>
                        <div class="menu__title">
                            Réclamations
                            <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ $reclamation_sub ?? '' }}">
                        <li>
                            <a href="{{ route('adminReclamationAgent') }}" class="menu {{ $reclamation1 ?? '' }}">
                                <div class="menu__icon"><i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Liste des réclamations Agent </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminReclamationClient') }}" class="menu {{ $reclamation2 ?? '' }}">
                                <div class="menu__icon"><i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Liste des réclamations Client </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav__devider my-6"></li>

                <li>
                    <a href="javascript:;" class="menu {{ $account ?? '' }}">
                        <div class="menu__icon"> <i data-lucide="users"></i> </div>
                        <div class="menu__title">
                            Comptes
                            <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ $account_sub ?? '' }}">
                        <li>
                            <a href="{{ route('adminNewCompte') }}" class="menu {{ $account1 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Nouveau Compte </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminCompte') }}" class="menu {{ $account2 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="menu__title"> Liste des Comptes </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" class="menu {{ $setting ?? '' }}">
                        <div class="menu__icon"> <i data-lucide="hard-drive"></i> </div>
                        <div class="menu__title">
                            Paramètres
                            <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ $setting_sub ?? '' }}">

                        <li>
                            <a href="javascript:;" class="menu {{ $setting1 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="hard-drive"></i> </div>
                                <div class="menu__title">
                                    Configuration
                                    <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                                </div>
                            </a>
                            <ul class="{{ $setting_sub1 ?? '' }}">
                                <li>
                                    <a href="" class="menu {{ $setting11 ?? '' }}">
                                        <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="menu__title">General</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="menu {{ $setting12 ?? '' }}">
                                        <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="menu__title">SMS</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="menu {{ $setting13 ?? '' }}">
                                        <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="menu__title">Whatsapp</div>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:;" class="menu {{ $setting2 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="dollar-sign"></i> </div>
                                <div class="menu__title">
                                    Paiements
                                    <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                                </div>
                            </a>
                            <ul class="{{ $setting_sub2 ?? '' }}">
                                <li>
                                    <a href="{{ route('adminMethode') }}" class="menu {{ $setting21 ?? '' }}">
                                        <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="menu__title">Méthodes de paiement</div>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:;" class="menu {{ $setting3 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="plus"></i> </div>
                                <div class="menu__title">
                                    Suppléments
                                    <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                                </div>
                            </a>
                            <ul class="{{ $setting_sub3 ?? '' }}">
                                <li>
                                    <a href="{{ route('adminSociete') }}" class="menu {{ $setting31 ?? '' }}">
                                        <div class="menu__icon"> <i data-lucide="home"></i> </div>
                                        <div class="menu__title">Société</div>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:;" class="menu {{ $setting4 ?? '' }}">
                                <div class="menu__icon"> <i data-lucide="send"></i> </div>
                                <div class="menu__title">
                                    Expéditions
                                    <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                                </div>
                            </a>
                            <ul class="{{ $setting_sub4 ?? '' }}">
                                <li>
                                    <a href="{{ route('adminService') }}" class="menu {{ $setting41 ?? '' }}">
                                        <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="menu__title">Services</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('adminEtape') }}" class="menu {{ $setting42 ?? '' }}">
                                        <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="menu__title">Étapes</div>
                                    </a>
                                </li>


                                <li>
                                    <a href="{{ route('adminDelai') }}" class="menu {{ $setting43 ?? '' }}">
                                        <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="menu__title">Delais d'expédition</div>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('adminPrice') }}" class="menu {{ $setting44 ?? '' }}">
                                        <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="menu__title">Tarif d'expédition</div>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('adminMode') }}" class="menu {{ $setting45 ?? '' }}">
                                        <div class="menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="menu__title">Mode d'expédition</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('adminMouchard') }}" class="menu">
                        <div class="menu__icon"> <i data-lucide="command"></i> </div>
                        <div class="menu__title">
                            Log
                            <div class="menu__sub-icon "> </div>
                        </div>
                    </a>
                </li>

                <li class="nav__devider my-6"></li>

                {{-- <li>
                        <a href="" class="menu"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="menu__icon"> <i data-lucide="log-out"></i> </div>
                            <div class="menu__title"> Déconnexion </div>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li> --}}




            </ul>
        </div>
    </div>
    <!-- END: Mobile Menu -->
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
                    <a href="{{ route('adminHome') }}" class="side-menu side-menu {{ $home ?? '' }}">
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
                                <div class="side-menu__title"> Liste des Dépêches </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminReservationList') }}" class="side-menu {{ $exp4 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Liste des Réservations </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="side-nav__devider my-6"></li>

                <li>
                    <a href="javascript:;" class="side-menu {{ $place ?? '' }}">
                        <div class="side-menu__icon"> <i data-lucide="map-pin"></i> </div>
                        <div class="side-menu__title">
                            Bureaux de Poste
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ $place_sub ?? '' }}">
                        <li>
                            <a href="{{ route('adminReseaux') }}" class="side-menu {{ $place1 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Réseaux </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminZones') }}" class="side-menu {{ $place2 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Zones </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminPays') }}" class="side-menu {{ $place3 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Pays </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminProvince') }}" class="side-menu {{ $place4 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Provinces </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminVille') }}" class="side-menu {{ $place5 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Villes </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminAgence') }}" class="side-menu {{ $place6 ?? '' }}">
                                <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                <div class="side-menu__title">Bureaux de Poste</div>
                            </a>
                        </li>
                    </ul>
                </li>

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
                            <a href="{{ route('adminPaiement') }}" class="side-menu {{ $transaction1 ?? '' }}">
                                <div class="side-menu__icon"><i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Liste des paiements </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" class="side-menu {{ $reclamation ?? '' }}">
                        <div class="side-menu__icon"> <i data-lucide="message-square"></i> </div>
                        <div class="side-menu__title">
                            Réclamations
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ $reclamation_sub ?? '' }}">
                        <li>
                            <a href="{{ route('adminReclamationAgent') }}"
                                class="side-menu {{ $reclamation1 ?? '' }}">
                                <div class="side-menu__icon"><i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Liste des réclamations Agent </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('adminReclamationClient') }}"
                                class="side-menu {{ $reclamation2 ?? '' }}">
                                <div class="side-menu__icon"><i data-lucide="minus"></i> </div>
                                <div class="side-menu__title"> Liste des réclamations Client </div>
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
                                    <a href="{{ route('adminMethode') }}"
                                        class="side-menu {{ $setting21 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Méthodes de paiement</div>
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
                                    <a href="{{ route('adminSociete') }}"
                                        class="side-menu {{ $setting31 ?? '' }}">
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
                                    <a href="{{ route('adminService') }}"
                                        class="side-menu {{ $setting41 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Services</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('adminEtape') }}" class="side-menu {{ $setting42 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Étapes</div>
                                    </a>
                                </li>


                                <li>
                                    <a href="{{ route('adminDelai') }}" class="side-menu {{ $setting43 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Delais d'expédition</div>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('adminPrice') }}" class="side-menu {{ $setting44 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Tarif d'expédition</div>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('adminMode') }}" class="side-menu {{ $setting45 ?? '' }}">
                                        <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                                        <div class="side-menu__title">Mode d'expédition</div>
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
                    <div class="dropdown-toggle notification {{ $user->unreadNotifications->count() > 0 ? 'notification--bullet' : '' }} cursor-pointer"
                        role="button" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="bell"
                            class="notification__icon dark:text-slate-500"></i> </div>
                    <div class="notification-content pt-2 dropdown-menu">
                        <div class="notification-content__box dropdown-content">
                            <div class="notification-content__title">Notifications</div>
                            @if ($user->unreadNotifications->count() > 0)
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($user->unreadNotifications as $notification)
                                    <div class="cursor-pointer relative flex items-center mt-5">
                                        <div class="w-12 h-12 flex-none image-fit mr-1">
                                            <img alt="Midone - HTML Admin Template" class="rounded-full"
                                                src="{{ URL::to('assets/dist/images/logos/icon_bleu.png') }}">
                                            <div
                                                class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white dark:border-darkmode-600">
                                            </div>
                                        </div>
                                        <div class="ml-2 overflow-hidden">
                                            <div class="flex items-center">

                                                <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">
                                                    {{ date_format(date_create($notification->data['date']), 'd M Y') }}
                                                </div>
                                            </div>
                                            <div class="w-full truncate text-slate-500 mt-0.5">
                                                {{ $notification->data['title'] ?? '' }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="cursor-pointer relative flex items-center mt-5">
                                    <div class="ml-2 overflow-hidden">
                                        <div class="w-full truncate text-slate-500 mt-0.5">Pas de notifications pour le
                                            moment</div>
                                    </div>
                                </div>
                            @endif
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
                        <strong>Succès !</strong> {{ ' ' . Session::get('success') }}. <button type="button"
                            class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i
                                data-lucide="x" class="w-4 h-4"></i> </button>
                    </div>
                    <br>
                @endif

                @if (Session::get('failed'))
                    <div class="alert alert-danger alert-dismissible show flex items-center mb-2" role="alert"
                        id="alert"> <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i> <strong>Attention !
                        </strong> {{ ' ' . Session::get('failed') }}. <button type="button"
                            class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i
                                data-lucide="x" class="w-4 h-4"></i>
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
