@extends('layouts.admin')

@section('page-content')

    <div class="col-span-12 2xl:col-span-12">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Statistiques
                    </h2>

                    <div class="ml-auto flex items-center">
                        <a href="{{ route('adminNewExpedition') }}" class="btn btn-primary shadow-md mr-2">Nouvelle
                            Expédition</a>
                        <a href="" class="ml-auto flex items-center text-primary">
                            <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i>
                            {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->translatedFormat('l jS F Y') }}
                        </a>
                    </div>

                </div>

                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="navigation" class="report-box__icon text-primary"></i>
                                    <!--div class="ml-auto">
                                                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                                                            </div-->
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">
                                    {{ $expeditions->count() }}
                                </div>
                                <div class="text-base text-slate-500 mt-1">Expeditions</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="credit-card" class="report-box__icon text-pending"></i>
                                    <!--div class="ml-auto">
                                                                                <div class="report-box__indicator bg-danger tooltip cursor-pointer" title="2% Lower than last month"> 2% <i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i> </div>
                                                                            </div-->
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">
                                    {{ $paiements->count() }}
                                </div>
                                <div class="text-base text-slate-500 mt-1">Paiements</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="users" class="report-box__icon text-warning"></i>
                                    <!--div class="ml-auto">
                                                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="12% Higher than last month"> 12% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                                                            </div-->
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">
                                    {{ $clients->count() }}
                                </div>
                                <div class="text-base text-slate-500 mt-1">Clients</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="package" class="report-box__icon text-success"></i>
                                    <!--div class="ml-auto">
                                                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="22% Higher than last month"> 22% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                                                            </div-->
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">
                                    {{ $packages->count() }}
                                </div>
                                <div class="text-base text-slate-500 mt-1">Packages</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 grid grid-cols-12 gap-6 mt-8">
                    <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y">
                        <div class="box p-5 zoom-in">
                            <div class="flex items-center">
                                <div class="w-2/4 flex-none">
                                    <div class="text-lg font-medium truncate">Target Sales</div>
                                    <div class="text-slate-500 mt-1">300 Sales</div>
                                </div>
                                <div class="flex-none ml-auto relative">
                                    <div class="w-[90px] h-[90px]">
                                        <canvas id="report-donut-chart-1" width="180" height="180"
                                            style="display: block; box-sizing: border-box; height: 90px; width: 90px;"></canvas>
                                    </div>
                                    <div
                                        class="font-medium absolute w-full h-full flex items-center justify-center top-0 left-0">
                                        20%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y">
                        <div class="box p-5 zoom-in">
                            <div class="flex">
                                <div class="text-lg font-medium truncate mr-3">Social Media</div>
                                <div
                                    class="py-1 px-2 flex items-center rounded-full text-xs bg-slate-100 dark:bg-darkmode-400 text-slate-500 cursor-pointer ml-auto truncate">
                                    320 Followers</div>
                            </div>
                            <div class="mt-1">
                                <div class="h-[58px]">
                                    <canvas class="simple-line-chart-1 -ml-1" width="389" height="116"
                                        style="display: block; box-sizing: border-box; height: 58px; width: 194.5px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y">
                        <div class="box p-5 zoom-in">
                            <div class="flex items-center">
                                <div class="w-2/4 flex-none">
                                    <div class="text-lg font-medium truncate">New Products</div>
                                    <div class="text-slate-500 mt-1">1450 Products</div>
                                </div>
                                <div class="flex-none ml-auto relative">
                                    <div class="w-[90px] h-[90px]">
                                        <canvas id="report-donut-chart-2" width="180" height="180"
                                            style="display: block; box-sizing: border-box; height: 90px; width: 90px;"></canvas>
                                    </div>
                                    <div
                                        class="font-medium absolute w-full h-full flex items-center justify-center top-0 left-0">
                                        45%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y">
                        <div class="box p-5 zoom-in">
                            <div class="flex">
                                <div class="text-lg font-medium truncate mr-3">Posted Ads</div>
                                <div
                                    class="py-1 px-2 flex items-center rounded-full text-xs bg-slate-100 dark:bg-darkmode-400 text-slate-500 cursor-pointer ml-auto truncate">
                                    180 Campaign</div>
                            </div>
                            <div class="mt-1">
                                <div class="h-[58px]">
                                    <canvas class="simple-line-chart-1 -ml-1" width="389" height="116"
                                        style="display: block; box-sizing: border-box; height: 58px; width: 194.5px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" icon-name="shopping-cart"
                                        data-lucide="shopping-cart"
                                        class="lucide lucide-shopping-cart report-box__icon text-primary">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"></path>
                                    </svg>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success tooltip cursor-pointer"> 33% <svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                icon-name="chevron-up" data-lucide="chevron-up"
                                                class="lucide lucide-chevron-up w-4 h-4 ml-0.5">
                                                <polyline points="18 15 12 9 6 15"></polyline>
                                            </svg> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">4.710</div>
                                <div class="text-base text-slate-500 mt-1">Item Sales</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" icon-name="credit-card"
                                        data-lucide="credit-card"
                                        class="lucide lucide-credit-card report-box__icon text-pending">
                                        <rect x="1" y="4" width="22" height="16"
                                            rx="2" ry="2"></rect>
                                        <line x1="1" y1="10" x2="23" y2="10"></line>
                                    </svg>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-danger tooltip cursor-pointer"> 2% <svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                icon-name="chevron-down" data-lucide="chevron-down"
                                                class="lucide lucide-chevron-down w-4 h-4 ml-0.5">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">3.721</div>
                                <div class="text-base text-slate-500 mt-1">New Orders</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" icon-name="monitor"
                                        data-lucide="monitor" class="lucide lucide-monitor report-box__icon text-warning">
                                        <rect x="2" y="3" width="20" height="14"
                                            rx="2" ry="2"></rect>
                                        <line x1="8" y1="21" x2="16" y2="21"></line>
                                        <line x1="12" y1="17" x2="12" y2="21"></line>
                                    </svg>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success tooltip cursor-pointer"> 12% <svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                icon-name="chevron-up" data-lucide="chevron-up"
                                                class="lucide lucide-chevron-up w-4 h-4 ml-0.5">
                                                <polyline points="18 15 12 9 6 15"></polyline>
                                            </svg> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">2.149</div>
                                <div class="text-base text-slate-500 mt-1">Total Products</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" icon-name="user"
                                        data-lucide="user" class="lucide lucide-user report-box__icon text-success">
                                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success tooltip cursor-pointer"> 22% <svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                icon-name="chevron-up" data-lucide="chevron-up"
                                                class="lucide lucide-chevron-up w-4 h-4 ml-0.5">
                                                <polyline points="18 15 12 9 6 15"></polyline>
                                            </svg> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">152.040</div>
                                <div class="text-base text-slate-500 mt-1">Unique Visitor</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: General Report -->

            <!-- BEGIN: Weekly Top Products -->
            <div class="col-span-12 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Dernieres expeditions
                    </h2>
                </div>
                <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                    <table class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap text-center">SUIVI</th>
                                <th class="text-center whitespace-nowrap">DATE</th>
                                <th class="text-center whitespace-nowrap">ORIGINE</th>
                                <th class="text-center whitespace-nowrap">DESTINATION</th>
                                <th class="text-center whitespace-nowrap">PAIEMENT</th>
                                <th class="text-center whitespace-nowrap">STATUT</th>
                                <th class="text-center whitespace-nowrap">COUT TOTAL</th>
                                <th class="text-center whitespace-nowrap">STATUT FACTURE</th>
                                <th class="text-center whitespace-nowrap">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($expeditions)
                                @foreach ($expeditions as $expedition)
                                    <tr class="intro-x">
                                        <td class="text-center bg-primary">
                                            <a class="text-primary"
                                                href="{{ route('adminSuiviExpedition', ['code' => $expedition->code_aleatoire]) }}"
                                                target="_blank">
                                                {{ $expedition->code_aleatoire }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($expedition->created_at)->translatedFormat('l jS F Y') }}
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">
                                                {{ $expedition->name_exp }}
                                            </a>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                                {{ $expedition->adresse_exp }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">
                                                {{ $expedition->name_dest }}
                                            </a>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                                {{ $expedition->adresse_dest }}
                                            </div>
                                        </td>
                                        <td class="text-center">

                                        </td>
                                        <td class="text-center">

                                        </td>
                                        <td class="text-center">
                                            {{ $expedition->amount ? $expedition->amount : 0 }} XAF
                                        </td>
                                        <td class="w-40">
                                            @if ($expedition->active == 1)
                                                <div class="flex items-center justify-center text-warning"> <i
                                                        data-lucide="check-square" class="w-4 h-4 mr-2"></i> En attente de
                                                    paiement </div>
                                            @elseif($expedition->active == 2)
                                                <div class="flex items-center justify-center text-success"> <i
                                                        data-lucide="check-square" class="w-4 h-4 mr-2"></i> Paye(e)
                                                </div>
                                            @elseif($expedition->active == 3)
                                                <div class="flex items-center justify-center text-success"> <i
                                                        data-lucide="check-square" class="w-4 h-4 mr-2"></i> CNT </div>
                                            @elseif($expedition->active == 2)
                                                <div class="flex items-center justify-center text-success"> <i
                                                        data-lucide="check-square" class="w-4 h-4 mr-2"></i> Livre(e)
                                                </div>
                                            @else
                                                <div class="flex items-center justify-center text-warning"> <i
                                                        data-lucide="check-square" class="w-4 h-4 mr-2"></i> Inactive
                                                </div>
                                            @endif
                                        </td>
                                        <td class="table-report__action w-56">
                                            <div class="flex justify-center items-center">
                                                <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-primary" aria-expanded="false"
                                                        data-tw-toggle="dropdown">Actions
                                                    </button>
                                                    <div class="dropdown-menu w-40">
                                                        <ul class="dropdown-content">

                                                            <li>
                                                                <a href="{{ route('adminFactureExpedition', ['code' => $expedition->code_aleatoire]) }}"
                                                                    class="dropdown-item" target="_blank">Facture</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('adminEtiquetteExpedition', ['code' => $expedition->code_aleatoire]) }}"
                                                                    class="dropdown-item" target="_blank">Etiquette</a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="intro-x">
                                    <td class="text-center">ras</td>
                                    <td class="text-center">ras</td>
                                    <td class="text-center">ras</td>
                                    <td class="text-center">ras</td>
                                    <td class="text-center">ras</td>
                                </tr>
                            @endif


                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END: Weekly Top Products -->



            <!-- BEGIN: Sales Report -->
            <div class="col-span-12 lg:col-span-12 mt-8">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Rapport Expedition (2023)
                    </h2>
                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="report-chart">
                        <div class="h-[275px]">
                            <canvas id="report-line-chart" class="mt-6 -mb-6"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Sales Report -->


        </div>
    </div>




@endsection
