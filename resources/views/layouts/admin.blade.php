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
                    <a href="javascript:;.html" class="menu menu--active">
                        <div class="menu__icon"> <i data-lucide="home"></i> </div>
                        <div class="menu__title"> Dashboard <i data-lucide="chevron-down"
                                class="menu__sub-icon transform rotate-180"></i> </div>
                    </a>
                    <ul class="menu__sub-open">
                        <li>
                            <a href="index.html" class="menu menu--active">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Overview 1 </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-dashboard-overview-2.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Overview 2 </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-dashboard-overview-3.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Overview 3 </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-dashboard-overview-4.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Overview 4 </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon"> <i data-lucide="box"></i> </div>
                        <div class="menu__title"> Menu Layout <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="index.html" class="menu menu--active">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Side Menu </div>
                            </a>
                        </li>
                        <li>
                            <a href="simple-menu-light-dashboard-overview-1.html" class="menu menu--active">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Simple Menu </div>
                            </a>
                        </li>
                        <li>
                            <a href="top-menu-light-dashboard-overview-1.html" class="menu menu--active">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Top Menu </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon"> <i data-lucide="shopping-bag"></i> </div>
                        <div class="menu__title"> E-Commerce <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="side-menu-light-categories.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Categories </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-add-product.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Add Product </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Products <i data-lucide="chevron-down"
                                        class="menu__sub-icon "></i> </div>
                            </a>
                            <ul class="">
                                <li>
                                    <a href="side-menu-light-product-list.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Product List</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-product-grid.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Product Grid</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Transactions <i data-lucide="chevron-down"
                                        class="menu__sub-icon "></i> </div>
                            </a>
                            <ul class="">
                                <li>
                                    <a href="side-menu-light-transaction-list.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Transaction List</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-transaction-detail.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Transaction Detail</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Sellers <i data-lucide="chevron-down"
                                        class="menu__sub-icon "></i> </div>
                            </a>
                            <ul class="">
                                <li>
                                    <a href="side-menu-light-seller-list.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Seller List</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-seller-detail.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Seller Detail</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="side-menu-light-reviews.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Reviews </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="side-menu-light-inbox.html" class="menu">
                        <div class="menu__icon"> <i data-lucide="inbox"></i> </div>
                        <div class="menu__title"> Inbox </div>
                    </a>
                </li>
                <li>
                    <a href="side-menu-light-file-manager.html" class="menu">
                        <div class="menu__icon"> <i data-lucide="hard-drive"></i> </div>
                        <div class="menu__title"> File Manager </div>
                    </a>
                </li>
                <li>
                    <a href="side-menu-light-point-of-sale.html" class="menu">
                        <div class="menu__icon"> <i data-lucide="credit-card"></i> </div>
                        <div class="menu__title"> Point of Sale </div>
                    </a>
                </li>
                <li>
                    <a href="side-menu-light-chat.html" class="menu">
                        <div class="menu__icon"> <i data-lucide="message-square"></i> </div>
                        <div class="menu__title"> Chat </div>
                    </a>
                </li>
                <li>
                    <a href="side-menu-light-post.html" class="menu">
                        <div class="menu__icon"> <i data-lucide="file-text"></i> </div>
                        <div class="menu__title"> Post </div>
                    </a>
                </li>
                <li>
                    <a href="side-menu-light-calendar.html" class="menu">
                        <div class="menu__icon"> <i data-lucide="calendar"></i> </div>
                        <div class="menu__title"> Calendar </div>
                    </a>
                </li>
                <li class="menu__devider my-6"></li>
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon"> <i data-lucide="edit"></i> </div>
                        <div class="menu__title"> Crud <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="side-menu-light-crud-data-list.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Data List </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-crud-form.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Form </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon"> <i data-lucide="users"></i> </div>
                        <div class="menu__title"> Users <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="side-menu-light-users-layout-1.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Layout 1 </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-users-layout-2.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Layout 2 </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-users-layout-3.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Layout 3 </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon"> <i data-lucide="trello"></i> </div>
                        <div class="menu__title"> Profile <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="side-menu-light-profile-overview-1.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Overview 1 </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-profile-overview-2.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Overview 2 </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-profile-overview-3.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Overview 3 </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon"> <i data-lucide="layout"></i> </div>
                        <div class="menu__title"> Pages <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="javascript:;" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Wizards <i data-lucide="chevron-down"
                                        class="menu__sub-icon "></i> </div>
                            </a>
                            <ul class="">
                                <li>
                                    <a href="side-menu-light-wizard-layout-1.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Layout 1</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-wizard-layout-2.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Layout 2</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-wizard-layout-3.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Layout 3</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Blog <i data-lucide="chevron-down"
                                        class="menu__sub-icon "></i> </div>
                            </a>
                            <ul class="">
                                <li>
                                    <a href="side-menu-light-blog-layout-1.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Layout 1</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-blog-layout-2.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Layout 2</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-blog-layout-3.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Layout 3</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Pricing <i data-lucide="chevron-down"
                                        class="menu__sub-icon "></i> </div>
                            </a>
                            <ul class="">
                                <li>
                                    <a href="side-menu-light-pricing-layout-1.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Layout 1</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-pricing-layout-2.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Layout 2</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Invoice <i data-lucide="chevron-down"
                                        class="menu__sub-icon "></i> </div>
                            </a>
                            <ul class="">
                                <li>
                                    <a href="side-menu-light-invoice-layout-1.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Layout 1</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-invoice-layout-2.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Layout 2</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> FAQ <i data-lucide="chevron-down"
                                        class="menu__sub-icon "></i> </div>
                            </a>
                            <ul class="">
                                <li>
                                    <a href="side-menu-light-faq-layout-1.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Layout 1</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-faq-layout-2.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Layout 2</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-faq-layout-3.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Layout 3</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="login-light-login.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Login </div>
                            </a>
                        </li>
                        <li>
                            <a href="login-light-register.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Register </div>
                            </a>
                        </li>
                        <li>
                            <a href="main-light-error-page.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Error Page </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-update-profile.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Update profile </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-change-password.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Change Password </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu__devider my-6"></li>
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon"> <i data-lucide="inbox"></i> </div>
                        <div class="menu__title"> Components <i data-lucide="chevron-down"
                                class="menu__sub-icon "></i> </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="javascript:;" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Table <i data-lucide="chevron-down"
                                        class="menu__sub-icon "></i> </div>
                            </a>
                            <ul class="">
                                <li>
                                    <a href="side-menu-light-regular-table.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Regular Table</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-tabulator.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Tabulator</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Overlay <i data-lucide="chevron-down"
                                        class="menu__sub-icon "></i> </div>
                            </a>
                            <ul class="">
                                <li>
                                    <a href="side-menu-light-modal.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Modal</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-slide-over.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Slide Over</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-notification.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Notification</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="side-menu-light-tab.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Tab </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-accordion.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Accordion </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-button.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Button </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-alert.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Alert </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-progress-bar.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Progress Bar </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-tooltip.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Tooltip </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-dropdown.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Dropdown </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-typography.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Typography </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-icon.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Icon </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-loading-icon.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Loading Icon </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon"> <i data-lucide="sidebar"></i> </div>
                        <div class="menu__title"> Forms <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="side-menu-light-regular-form.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Regular Form </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-datepicker.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Datepicker </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-tom-select.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Tom Select </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-file-upload.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> File Upload </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Wysiwyg Editor <i data-lucide="chevron-down"
                                        class="menu__sub-icon "></i> </div>
                            </a>
                            <ul class="">
                                <li>
                                    <a href="side-menu-light-wysiwyg-editor-classic.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Classic</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-wysiwyg-editor-inline.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Inline</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-wysiwyg-editor-balloon.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Balloon</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-wysiwyg-editor-balloon-block.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Balloon Block</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="side-menu-light-wysiwyg-editor-document.html" class="menu">
                                        <div class="menu__icon"> <i data-lucide="zap"></i> </div>
                                        <div class="menu__title">Document</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="side-menu-light-validation.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Validation </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon"> <i data-lucide="hard-drive"></i> </div>
                        <div class="menu__title"> Widgets <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="side-menu-light-chart.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Chart </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-slider.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Slider </div>
                            </a>
                        </li>
                        <li>
                            <a href="side-menu-light-image-zoom.html" class="menu">
                                <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="menu__title"> Image Zoom </div>
                            </a>
                        </li>
                    </ul>
                </li>
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
                                    <a href="{{ route('adminMethode') }}" class="side-menu {{ $setting21 ?? '' }}">
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
