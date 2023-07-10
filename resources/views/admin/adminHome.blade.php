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
                <!--div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                    <button class="btn box flex items-center text-slate-600 dark:text-slate-300"> <i data-lucide="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to Excel </button>
                    <button class="ml-3 btn box flex items-center text-slate-600 dark:text-slate-300"> <i data-lucide="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to PDF </button>
                </div-->
            </div>
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">SUIVI</th>
                            <th class="whitespace-nowrap">DATE</th>

                            <th class="text-center whitespace-nowrap">EXPEDITEUR</th>
                            <th class="text-center whitespace-nowrap">DESTINATAIRE</th>

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

                        <tr class="intro-x">

                            <td class="text-center text-primary">
                            	<a href="">AWB9840107860</a>
                            </td>
                            <td class="text-center">22/07/2023</td>

                            <td class="text-center">Jolie Becroft</td>
                            <td class="text-center">Fouad MA</td>

                            <td class="text-center">GA, LBV</td>
                            <td class="text-center">GA, POG</td>

                            <td class="text-center">PEE</td>
                            <td class="w-40">
                                <div class="flex items-center justify-center text-warning"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> ENA </div>
                            </td>
                            <td class="text-center">12 800 XAF</td>
                            <td class="w-40">
                                <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Paye </div>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="dropdown"> 
                                	<button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">
                                		Actions
                                	</button> 
                                	<div class="dropdown-menu w-40"> 
                                		<ul class="dropdown-content"> 
                                			<li> 
                                				<a href="" class="dropdown-item"> 
                                					<i data-lucide="printer" class="w-4 h-4 mr-2"></i> 
                                					Facture 
                                				</a> 
                                			</li> 
                                			<li> 
                                				<a href="" class="dropdown-item"> 
                                					<i data-lucide="printer" class="w-4 h-4 mr-2"></i> 
                                					Etiquette 
                                				</a> 
                                			</li>
                                			<li> 
                                				<a href="" class="dropdown-item"> 
                                					<i data-lucide="eye" class="w-4 h-4 mr-2"></i> 
                                					Details 
                                				</a> 
                                			</li> 
                                			<li> 
                                				<a href="" class="dropdown-item"> 
                                					<i data-lucide="edit" class="w-4 h-4 mr-2"></i> 
                                					Modification 
                                				</a> 
                                			</li> 
                                		</ul> 
                                	</div> 
                                </div>
                            </td>
                        </tr>
                        <tr class="intro-x">

                            <td class="text-center text-primary">
                            	<a href="">AWB9840107860</a>
                            </td>
                            <td class="text-center">22/07/2023</td>

                            <td class="text-center">Jolie Becroft</td>
                            <td class="text-center">Fouad MA</td>

                            <td class="text-center">GA, LBV</td>
                            <td class="text-center">GA, POG</td>

                            <td class="text-center">PEE</td>
                            <td class="w-40">
                                <div class="flex items-center justify-center text-warning"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> ENA </div>
                            </td>
                            <td class="text-center">12 800 XAF</td>
                            <td class="w-40">
                                <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Paye </div>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="dropdown"> 
                                	<button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">
                                		Actions
                                	</button> 
                                	<div class="dropdown-menu w-40"> 
                                		<ul class="dropdown-content"> 
                                			<li> 
                                				<a href="" class="dropdown-item"> 
                                					<i data-lucide="printer" class="w-4 h-4 mr-2"></i> 
                                					Facture 
                                				</a> 
                                			</li> 
                                			<li> 
                                				<a href="" class="dropdown-item"> 
                                					<i data-lucide="printer" class="w-4 h-4 mr-2"></i> 
                                					Etiquette 
                                				</a> 
                                			</li>
                                			<li> 
                                				<a href="" class="dropdown-item"> 
                                					<i data-lucide="eye" class="w-4 h-4 mr-2"></i> 
                                					Details 
                                				</a> 
                                			</li> 
                                			<li> 
                                				<a href="" class="dropdown-item"> 
                                					<i data-lucide="edit" class="w-4 h-4 mr-2"></i> 
                                					Modification 
                                				</a> 
                                			</li> 
                                		</ul> 
                                	</div> 
                                </div> 
                            </td>
                        </tr>
                        <tr class="intro-x">

                            <td class="text-center text-primary">
                            	<a href="">AWB9840107860</a>
                            </td>
                            <td class="text-center">22/07/2023</td>

                            <td class="text-center">Jolie Becroft</td>
                            <td class="text-center">Fouad MA</td>

                            <td class="text-center">GA, LBV</td>
                            <td class="text-center">GA, POG</td>

                            <td class="text-center">PEE</td>
                            <td class="w-40">
                                <div class="flex items-center justify-center text-warning"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> ENA </div>
                            </td>
                            <td class="text-center">12 800 XAF</td>
                            <td class="w-40">
                                <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Paye </div>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="dropdown"> 
                                	<button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">
                                		Actions
                                	</button> 
                                	<div class="dropdown-menu w-40"> 
                                		<ul class="dropdown-content"> 
                                			<li> 
                                				<a href="" class="dropdown-item"> 
                                					<i data-lucide="printer" class="w-4 h-4 mr-2"></i> 
                                					Facture 
                                				</a> 
                                			</li> 
                                			<li> 
                                				<a href="" class="dropdown-item"> 
                                					<i data-lucide="printer" class="w-4 h-4 mr-2"></i> 
                                					Etiquette 
                                				</a> 
                                			</li>
                                			<li> 
                                				<a href="" class="dropdown-item"> 
                                					<i data-lucide="eye" class="w-4 h-4 mr-2"></i> 
                                					Details 
                                				</a> 
                                			</li> 
                                			<li> 
                                				<a href="" class="dropdown-item"> 
                                					<i data-lucide="edit" class="w-4 h-4 mr-2"></i> 
                                					Modification 
                                				</a> 
                                			</li> 
                                		</ul> 
                                	</div> 
                                </div>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                <nav class="w-full sm:w-auto sm:mr-auto">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevrons-left"></i> </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevron-left"></i> </a>
                        </li>
                        <li class="page-item"> <a class="page-link" href="#">...</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">1</a> </li>
                        <li class="page-item active"> <a class="page-link" href="#">2</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">3</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">...</a> </li>
                        <li class="page-item">
                            <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevron-right"></i> </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevrons-right"></i> </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- END: Weekly Top Products -->



        <!-- BEGIN: Sales Report -->
        <div class="col-span-12 lg:col-span-12 mt-8">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Rapport Expedition
                </h2>
                <!--div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                    <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i> 
                    <input type="text" class="datepicker form-control sm:w-56 box pl-10">
                </div-->
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <!--div class="flex flex-col md:flex-row md:items-center">
                    <div class="flex">
                        <div>
                            <div class="text-primary dark:text-slate-300 text-lg xl:text-xl font-medium">$15,000</div>
                            <div class="mt-0.5 text-slate-500">This Month</div>
                        </div>
                        <div class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5"></div>
                        <div>
                            <div class="text-slate-500 text-lg xl:text-xl font-medium">$10,000</div>
                            <div class="mt-0.5 text-slate-500">Last Month</div>
                        </div>
                    </div>
                    <div class="dropdown md:ml-auto mt-5 md:mt-0">
                        <button class="dropdown-toggle btn btn-outline-secondary font-normal" aria-expanded="false" data-tw-toggle="dropdown"> Filter by Category <i data-lucide="chevron-down" class="w-4 h-4 ml-2"></i> </button>
                        <div class="dropdown-menu w-40">
                            <ul class="dropdown-content overflow-y-auto h-32">
                                <li><a href="" class="dropdown-item">PC & Laptop</a></li>
                                <li><a href="" class="dropdown-item">Smartphone</a></li>
                                <li><a href="" class="dropdown-item">Electronic</a></li>
                                <li><a href="" class="dropdown-item">Photography</a></li>
                                <li><a href="" class="dropdown-item">Sport</a></li>
                            </ul>
                        </div>
                    </div>
                </div-->
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