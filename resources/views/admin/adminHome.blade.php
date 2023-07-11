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
                <a href="" class="ml-auto flex items-center text-primary"> 
                	<i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> 
                	{{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->translatedFormat('l jS F Y') }} 
                </a>
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

                        @if($expeditions)

                        @foreach($expeditions as $expedition)
                            <tr class="intro-x">
                                <td class="text-center bg-primary">
                                    <a class="text-primary" href="{{ route('adminSuiviExpedition', ['code' => $expedition->code_aleatoire]) }}" target="_blank">
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
                                    @if($expedition->active == 1)
                                    <div class="flex items-center justify-center text-warning"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> En attente de paiement </div>
                                    @elseif($expedition->active == 2)
                                    <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Paye(e) </div>
                                    @elseif($expedition->active == 3)
                                    <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> CNT </div>
                                    @elseif($expedition->active == 2)
                                    <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Livre(e) </div>
                                    @else
                                    <div class="flex items-center justify-center text-warning"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Inactive </div>
                                    @endif
                                </td>
                                <td class="table-report__action w-56">
                                    <div class="flex justify-center items-center">
                                        <div class="dropdown"> 
                                            <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">Actions
                                            </button> 
                                            <div class="dropdown-menu w-40"> 
                                                <ul class="dropdown-content">

                                                    <li> 
                                                        <a href="{{ route('adminFactureExpedition', ['code' => $expedition->code_aleatoire]) }}" class="dropdown-item" target="_blank">Facture</a> 
                                                    </li> 
                                                    <li> 
                                                        <a href="{{ route('adminEtiquetteExpedition', ['code' => $expedition->code_aleatoire]) }}" class="dropdown-item" target="_blank">Etiquette</a> 
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