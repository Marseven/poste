@extends('layouts.admin')
@php
    use App\Http\Controllers\Controller;
@endphp
@section('page-content')

    <div class="col-span-12 2xl:col-span-12">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">

                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Tableau de Bord
                    </h2>

                    <div class="ml-auto flex items-center">
                        <a href="{{ route('adminNewExpedition') }}" class="btn btn-warning shadow-md mr-2">Nouvelle
                            Expédition</a>
                        <a href="" class="ml-auto flex items-center text-primary">
                            <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i>
                            {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->translatedFormat('l jS F Y') }}
                        </a>
                    </div>
                </div>

                <br>

                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        <strong>Le Jour J</strong> <span class="text-md px-1 bg-danger text-white mr-1"
                            style="padding:5px; font-weight: 600;">
                            Mode : Accéléré</span>
                    </h2>
                </div>

                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                        <a href="{{ route('adminExpeditionJ') }}">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="package" class="report-box__icon text-danger"></i>
                                        <!--div class="ml-auto"> <div class="report-box__indicator bg-success tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>                                                                                                                                                                                                                        </div-->
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">
                                        {{ $exp_j->count() }}
                                    </div>
                                    <div class="text-base text-slate-500 mt-1">Nbre d'expéditions Aujourd'hui</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                        <a href="{{ route('adminExpeditionJ') }}">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="package" class="report-box__icon text-danger"></i>
                                        <!--div class="ml-auto">                                                                                                                                                                                                                                                                                                 </div-->
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">
                                        {{ $exp_j_pending->count() }}
                                    </div>
                                    <div class="text-base text-slate-500 mt-1">Nbre d'expéditions en cours</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                        <a href="{{ route('adminExpeditionJ') }}">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="package" class="report-box__icon text-danger"></i>
                                        <!--div class="ml-auto">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="report-box__indicator bg-success tooltip cursor-pointer" title="12% Higher than last month"> 12% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div-->
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">
                                        {{ $exp_j_do->count() }}
                                    </div>
                                    <div class="text-base text-slate-500 mt-1">Nbre d'expéditions livrées</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <br><br>
                <hr>
                <br>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <a href="{{ route('adminExpeditionList') }}">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="package" class="report-box__icon text-warning"></i>
                                        <!--div class="ml-auto">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="report-box__indicator bg-success tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div-->
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">
                                        {{ $exp->count() }}
                                    </div>
                                    <div class="text-base text-slate-500 mt-1">Nbre d'expéditions</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <a href="{{ route('adminExpeditionList') }}">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="package" class="report-box__icon text-warning"></i>
                                        <!--div class="ml-auto">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="report-box__indicator bg-danger tooltip cursor-pointer" title="2% Lower than last month"> 2% <i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i> </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div-->
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">
                                        {{ $exp_pending->count() }}
                                    </div>
                                    <div class="text-base text-slate-500 mt-1">Nbre d'expéditions en cours</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <a href="{{ route('adminExpeditionList') }}">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="package" class="report-box__icon text-warning"></i>
                                        <!--div class="ml-auto">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="report-box__indicator bg-success tooltip cursor-pointer" title="12% Higher than last month"> 12% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div-->
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">
                                        {{ $exp_do->count() }}
                                    </div>
                                    <div class="text-base text-slate-500 mt-1">Nbre d'expéditions livrées</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <a href="{{ route('adminExpeditionList') }}">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="package" class="report-box__icon text-warning"></i>
                                        <!--div class="ml-auto">                                                                                                                                                                                                                                                                                                            </div-->
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">
                                        {{ $reservations->count() }}
                                    </div>
                                    <div class="text-base text-slate-500 mt-1">Nbre de réservations</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- <div class="col-span-12 grid grid-cols-12 gap-6 mt-8">
                    <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y">
                        <div class="box p-5 zoom-in">
                            <div class="flex items-center">
                                <div class="w-2/4 flex-none">
                                    <div class="text-lg font-medium truncate">Tx réservation en ligne</div>
                                    <div class="text-slate-500 mt-1">0 Réservations en ligne</div>
                                </div>
                                <div class="flex-none ml-auto relative">
                                    <div class="w-[90px] h-[90px]">
                                        <canvas id="report-donut-chart-1" width="180" height="180"
                                            style="display: block; box-sizing: border-box; height: 90px; width: 90px;"></canvas>
                                    </div>
                                    <div
                                        class="font-medium absolute w-full h-full flex items-center justify-center top-0 left-0">
                                        0%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y">
                        <div class="box p-5 zoom-in">
                            <div class="flex items-center">
                                <div class="w-2/4 flex-none">
                                    <div class="text-lg font-medium truncate">Tx réservation complétée</div>
                                    <div class="text-slate-500 mt-1">0 Réservations complétées</div>
                                </div>
                                <div class="flex-none ml-auto relative">
                                    <div class="w-[90px] h-[90px]">
                                        <canvas id="report-donut-chart-2" width="180" height="180"
                                            style="display: block; box-sizing: border-box; height: 90px; width: 90px;"></canvas>
                                    </div>
                                    <div
                                        class="font-medium absolute w-full h-full flex items-center justify-center top-0 left-0">
                                        0%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y">
                        <div class="box p-5 zoom-in">
                            <div class="flex items-center">
                                <div class="w-2/4 flex-none">
                                    <div class="text-lg font-medium truncate">Tx réservation annulée</div>
                                    <div class="text-slate-500 mt-1">0 Réservations annulées</div>
                                </div>
                                <div class="flex-none ml-auto relative">
                                    <div class="w-[90px] h-[90px]">
                                        <canvas id="report-donut-chart-3" width="180" height="180"
                                            style="display: block; box-sizing: border-box; height: 90px; width: 90px;"></canvas>
                                    </div>
                                    <div
                                        class="font-medium absolute w-full h-full flex items-center justify-center top-0 left-0">
                                        0%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y">
                        <div class="box p-5 zoom-in">
                            <div class="flex items-center">
                                <div class="w-2/4 flex-none">
                                    <div class="text-lg font-medium truncate">Satisfaction Client</div>
                                    <div class="text-slate-500 mt-1">0 Feedback</div>
                                </div>
                                <div class="flex-none ml-auto relative">
                                    <div class="w-[90px] h-[90px]">
                                        <canvas id="report-donut-chart-3" width="180" height="180"
                                            style="display: block; box-sizing: border-box; height: 90px; width: 90px;"></canvas>
                                    </div>
                                    <div
                                        class="font-medium absolute w-full h-full flex items-center justify-center top-0 left-0">
                                        0%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> --}}

                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <a href="{{ route('adminPaiement') }}">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="dollar-sign" class="report-box__icon text-primary"></i>
                                        <div class="ml-auto">
                                            <div class="report-box__indicator bg-success tooltip cursor-pointer"> 0% <svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    icon-name="chevron-up" data-lucide="chevron-up"
                                                    class="lucide lucide-chevron-up w-4 h-4 ml-0.5">
                                                    <polyline points="18 15 12 9 6 15"></polyline>
                                                </svg> </div>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">
                                        {{ number_format($ca->am, 0, ',', ' ') ?? '0' }} FCFA</div>
                                    <div class="text-base text-slate-500 mt-1">Chiffre d'Affaire des expéditions</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="clock" class="report-box__icon text-primary"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success tooltip cursor-pointer"> 0% <svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                icon-name="chevron-up" data-lucide="chevron-up"
                                                class="lucide lucide-chevron-up w-4 h-4 ml-0.5">
                                                <polyline points="18 15 12 9 6 15"></polyline>
                                            </svg> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">0</div>
                                <div class="text-base text-slate-500 mt-1">Délais de livraison</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <a href="{{ route('adminReclamationClient') }}">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="message-square" class="report-box__icon text-primary"></i>
                                        <div class="ml-auto">
                                            <div class="report-box__indicator bg-success tooltip cursor-pointer"> 0% <svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    icon-name="chevron-up" data-lucide="chevron-up"
                                                    class="lucide lucide-chevron-up w-4 h-4 ml-0.5">
                                                    <polyline points="18 15 12 9 6 15"></polyline>
                                                </svg> </div>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6"> {{ $reclamations->count() }}</div>
                                    <div class="text-base text-slate-500 mt-1">Nbre de réclamations clients</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="clock" class="report-box__icon text-primary"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success tooltip cursor-pointer"> 0% <svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                icon-name="chevron-up" data-lucide="chevron-up"
                                                class="lucide lucide-chevron-up w-4 h-4 ml-0.5">
                                                <polyline points="18 15 12 9 6 15"></polyline>
                                            </svg> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">0</div>
                                <div class="text-base text-slate-500 mt-1">Délais de Traitement</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: General Report -->

            <!-- BEGIN: Sales Report -->
            <div class="col-span-12 lg:col-span-12 mt-8">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Chiffre d'Affaire ({{ date('Y') }})
                    </h2>
                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="report-chart">
                        <div class="h-[400px]"> <canvas id="vertical-bar-chart-widget"></canvas> </div>
                    </div>
                </div>
            </div>
            <!-- END: Sales Report -->

            <!-- BEGIN: Weekly Top Products -->
            <div class="col-span-12 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Dernières expeditions
                    </h2>
                </div>
                <div class="intro-y overflow-auto  mt-8 sm:mt-0">
                    <table class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap text-center">SUIVI</th>
                                <th class="text-center whitespace-nowrap">DATE</th>
                                <th class="text-center whitespace-nowrap">MODE</th>
                                <th class="text-center whitespace-nowrap">EXPEDITEUR</th>
                                <th class="text-center whitespace-nowrap">DESTINATAIRE</th>
                                <th class="text-center whitespace-nowrap">COUT TOTAL</th>
                                <th class="text-center whitespace-nowrap">STATUT FACTURE</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($expeditions->count() > 0)
                                @foreach ($expeditions as $expedition)
                                    <tr class="intro-x">
                                        <td class="text-center bg-primary">
                                            <a class="text-primary"
                                                href="{{ route('adminSuiviExpedition', ['code' => $expedition->code]) }}">
                                                {{ $expedition->code }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($expedition->created_at)->translatedFormat('d-m-Y') }}
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="text-md px-1 bg-{{ $expedition->mode_exp_id == 2 ? 'danger' : 'primary' }} text-white mr-1"
                                                style="padding:5px; font-weight: 600;">
                                                {{ $expedition->mode->libelle }}</span>
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
                                            {{ $expedition->amount ? $expedition->amount : 0 }} FCFA
                                        </td>
                                        <td class="w-40">
                                            @if ($expedition->status == 3)
                                                <div class="flex items-center justify-center text-success"> <i
                                                        data-lucide="check-square" class="w-4 h-4 mr-2"></i> Payée </div>
                                            @else
                                                <div class="flex items-center justify-center text-warning"> <i
                                                        data-lucide="check-square" class="w-4 h-4 mr-2"></i> En attente de
                                                    paiement </div>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if ($expeditions->count() == 0)
                        <div class="col-span-12 2xl:col-span-12">
                            <div class="alert alert-pending alert-dismissible show flex items-center mb-2" role="alert">
                                <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i> Aucun élément pour le
                                moment
                                !
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- END: Weekly Top Products -->
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        // if ($("#vertical-bar-chart-widget").length) {
        //     var _ctx10 = $("#vertical-bar-chart-widget")[0].getContext("2d");

        //     var _myChart4 = new chart_js_auto__WEBPACK_IMPORTED_MODULE_2__["default"](_ctx10, {
        //         type: "bar",
        //         data: {
        //             labels: ['Aou'],
        //             datasets: [{
        //                 label: "CA Mensuel",
        //                 barPercentage: 0.5,
        //                 barThickness: 6,
        //                 maxBarThickness: 8,
        //                 minBarLength: 3,
        //                 data: [1200],
        //                 backgroundColor: _colors__WEBPACK_IMPORTED_MODULE_1__["default"].primary()
        //             }]
        //         },
        //         options: {
        //             maintainAspectRatio: false,
        //             plugins: {
        //                 legend: {
        //                     labels: {
        //                         color: _colors__WEBPACK_IMPORTED_MODULE_1__["default"].slate[500](0.8)
        //                     }
        //                 }
        //             },
        //             scales: {
        //                 x: {
        //                     ticks: {
        //                         font: {
        //                             size: 12
        //                         },
        //                         color: _colors__WEBPACK_IMPORTED_MODULE_1__["default"].slate[500](0.8)
        //                     },
        //                     grid: {
        //                         display: false,
        //                         drawBorder: false
        //                     }
        //                 },
        //                 y: {
        //                     ticks: {
        //                         font: {
        //                             size: "12"
        //                         },
        //                         color: _colors__WEBPACK_IMPORTED_MODULE_1__["default"].slate[500](0.8),
        //                         callback: function callback(value, index, values) {
        //                             return value + " FCFA";
        //                         }
        //                     },
        //                     grid: {
        //                         color: $("html").hasClass("dark") ? _colors__WEBPACK_IMPORTED_MODULE_1__["default"]
        //                             .slate[500](0.3) : _colors__WEBPACK_IMPORTED_MODULE_1__["default"].slate[300](),
        //                         borderDash: [2, 2],
        //                         drawBorder: false
        //                     }
        //                 }
        //             }
        //         }
        //     });
        // }

        var ctx = document.getElementById('vertical-bar-chart-widget').getContext('2d');

        // Définissez les données du graphique
        var data = {
            labels: [
                @foreach ($ca_exp as $ca)
                    "{{ Controller::month($ca->mo) }}",
                @endforeach
            ], // Les étiquettes de l'axe X
            datasets: [{
                label: "Chiffre d'affaire mensuel",
                data: [
                    @foreach ($ca_exp as $ca)
                        {{ $ca->am }},
                    @endforeach
                ], // Les données du graphique
                backgroundColor: 'rgba(30, 64, 175, 0.2)', // Code couleur avec transparence
                borderColor: 'rgba(30, 64, 175, 1)',
                borderWidth: 1,
            }, ],
        };

        // Configurez les options du graphique
        var options = {
            responsive: true,
            maintainAspectRatio: false, // Pour ajuster la taille du canevas
            scales: {
                y: {
                    beginAtZero: true, // L'axe Y commence à zéro
                },
            },
        };

        // Créez le graphique de ligne
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options,
        });
    </script>

    {{-- @foreach ($ca_exp as $ca)
"{{ Controller::month($ca->mo) }}"
@endforeach
@foreach ($ca_exp as $ca)
{{ $ca->am }}
@endforeach --}}
@endpush
