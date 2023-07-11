@extends('layouts.admin')

@section('page-content')

			

	            <div class="intro-y flex items-center mt-8">
	                <h2 class="text-lg font-medium mr-auto">
	                    Package - {{ $package->code }}
	                </h2>
	            </div>

	            <div class="grid grid-cols-12 gap-6 mt-5">
                    <!-- BEGIN: Profile Menu -->
                    <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">

                    	<div class="intro-y box mt-5 lg:mt-0">
                            <div class="relative flex items-center p-5">
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium text-base">Note d'information</div>
                                    <div class="text-slate-500">
                                    	<strong><u>NB</u></strong> : Il est important de rappeller que les assignations de colis se font a partir de 14h30 et ne sont operationnels que le jour meme. donc passer la date d'aujourd'hui, le systeme ne permettra aucune assignation de colis.
                                    </div>
                                </div>
                            </div>
                        </div>

                    	<div class="intro-y box p-5 bg-primary text-white mt-5">
                            <div class="flex items-center">
                                <div class="font-medium text-lg">Types de packages</div>
                            </div>
                            <div class="mt-4">
                            	1. Type 1 [ Agence vers CNT ] <br>
                            	2. Type 2 [ CNT vers Agence ] <br>
                            </div>
                            
                        </div>


                    </div>
                    <!-- END: Profile Menu -->


                    
                    <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                        <!-- BEGIN: File Manager Filter -->
                        <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
                            <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                                <input type="text" class="form-control w-full sm:w-64 box px-10" placeholder="Rechercher colis...">
                                <i class="w-4 h-4 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-slate-500" data-lucide="search"></i> 
                            </div>
                        </div>
                        <!-- END: File Manager Filter -->

                        <!-- BEGIN: Directory & Files -->
                        <div class="intro-y grid grid-cols-12 gap-3 sm:gap-6 mt-5">

                        	@if($today_paquets)

	                            @foreach($today_paquets as $paquet)
	                            <div class="intro-y col-span-6 sm:col-span-4 md:col-span-4 2xl:col-span-4">
	                                <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
	                                    
	                                    <a href="" class="w-3/5 file__icon file__icon--file mx-auto">
	                                        <div class="file__icon__file-name">COLIS</div>
	                                    </a>
	                                    <a href="" class="block font-medium mt-4 text-center truncate">
	                                    	{{ $paquet->libelle }}
	                                    </a> 
	                                    <div class="text-slate-500 text-xs text-center mt-0.5">
	                                    	{{ $paquet->code }}
	                                    </div>
	                                    <div class="text-slate-500 text-xs text-center mt-0.5">
	                                    	@if($paquet->active == 1)
                                            <div class="flex items-center justify-center text-primary"> Enregistre(e) </div>
                                            @elseif($paquet->active == 2)
                                            <div class="flex items-center justify-center text-success"> Assigne(e) </div>
                                            @elseif($paquet->active == 3)
                                            <div class="flex items-center justify-center text-success"> CNT </div>
                                            @elseif($paquet->active == 4)
                                            <div class="flex items-center justify-center text-success"> Expedie(e) </div>
                                            @elseif($paquet->active == 5)
                                            <div class="flex items-center justify-center text-success"> Livre(e) </div>
                                            @else
                                            <div class="flex items-center justify-center text-warning"> Non defini </div>
                                            @endif
	                                    </div>
	                                    <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
	                                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-vertical" class="w-5 h-5 text-slate-500"></i> </a>
	                                        <div class="dropdown-menu w-40">
	                                            <ul class="dropdown-content">
	                                                <li>
	                                                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#confirm-{{ $paquet->id }}" class="dropdown-item"> <i data-lucide="users" class="w-4 h-4 mr-2"></i> Assigner </a>
	                                                </li>
	                                            </ul>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>

	                            <!-- BEGIN: Delete Confirmation Modal -->
					            <div id="confirm-{{ $paquet->id }}" class="modal" tabindex="-1" aria-hidden="true">
					                <div class="modal-dialog modal-lg">
								         <div class="modal-content">

								         	<form method="POST" action="{{ route('adminPackageAssign') }}">
								         		@csrf

								             <!-- BEGIN: Modal Header -->
								             <div class="modal-header">
								                 <h2 class="font-medium text-base mr-auto">Confirmation Assignation</h2> 
								             </div> 
								             <!-- END: Modal Header -->

								             <!-- BEGIN: Modal Body -->
								             <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
								                 <div class="col-span-12 sm:col-span-6"> 
						                 			<p>
						                 				Etes-vous sur de vouloir assigner ce colis au package {{ $package->code }} ?
						                 			</p> 
								                 	<input type="hidden" name="package_id" value="{{ $package->id }}">
								                 	<input type="hidden" name="package_code" value="{{ $package->code }}"> 
								                 	<input type="hidden" name="colis_id" value="{{ $paquet->id }}">  
								                 	<input type="hidden" name="paquet_code" value="{{ $paquet->code }}">
								                 </div>

								             </div> 
								             <!-- END: Modal Body -->

								             <!-- BEGIN: Modal Footer -->
								             <div class="modal-footer">
								             	<button type="submit" class="btn btn-primary w-20">Confirmer</button> 
								             </div> 
								             <!-- END: Modal Footer -->

								            </form>

								         </div>
								    </div>
					            </div>
					            <!-- END: Delete Confirmation Modal -->


	                            @endforeach

                            @else
                            <div class="alert alert-pending show flex items-center mb-2" role="alert"> <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i> Aucun colis pour le moment ! </div>
                            @endif


                        </div>
                        <!-- END: Directory & Files -->

                        <!-- BEGIN: Pagination -->
                        <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-6">
                            <nav class="w-full sm:w-auto sm:mr-auto">
                                {{ $today_paquets->links() }}
                            </nav>
                        </div>
                        <!-- END: Pagination -->
                    	


                    </div>
	            	







	            </div>




@endsection