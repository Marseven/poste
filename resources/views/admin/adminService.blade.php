@extends('layouts.admin')

@section('page-content')

			<div class="col-span-12 2xl:col-span-12">
				<h2 class="intro-y text-lg font-medium mt-10">
                    Liste des services
                </h2>
                <div class="grid grid-cols-12 gap-12 mt-5">
                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                        
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#large-modal-size-preview" class="btn btn-primary shadow-md mr-2">Nouveau Service</a>

                        <!-- BEGIN: Large Modal Content -->
						<!-- BEGIN: Modal Content -->
						<div id="large-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
						    <div class="modal-dialog modal-lg">
						         <div class="modal-content">
						         	<form method="POST" action="{{ route('adminAddService') }}">
						         		@csrf
						             <!-- BEGIN: Modal Header -->
						             <div class="modal-header">
						                 <h2 class="font-medium text-base mr-auto">Formulaire d'ajout</h2> 
						             </div> <!-- END: Modal Header -->
						             <!-- BEGIN: Modal Body -->
						             <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

						                 <div class="col-span-12 sm:col-span-6"> 
						                 	<label for="modal-form-1" class="form-label">Code</label> 
						                 	<input type="text" class="form-control" placeholder="FRT" name="code"> 
						                 </div>

						                 <div class="col-span-12 sm:col-span-6"> 
						                 	<label for="modal-form-2" class="form-label">Libelle</label> 
						                 	<input type="text" class="form-control" placeholder="FRET AERIEN" name="libelle"> 
						                 </div>

						                 <div class="col-span-12 sm:col-span-12"> 
						                 	<label for="modal-form-2" class="form-label">Description</label> 
						                 	<textarea name="description" class="form-control" rows="4"></textarea> 
						                 </div>

						                 
						                 <div class="col-span-12 sm:col-span-12"> 
						                 	<label for="modal-form-6" class="form-label">Statut</label> 
						                 	<select id="modal-form-6" class="form-select" name="active">
						                         <option value="1">active</option>
						                         <option value="0">inactif</option>
						                     </select> 
						                 </div>

						             </div> <!-- END: Modal Body -->
						             <!-- BEGIN: Modal Footer -->
						             <div class="modal-footer">
						             	<button type="submit" class="btn btn-primary w-20">Soumettre</button> 
						             </div> 
						             <!-- END: Modal Footer -->
						            </form>
						         </div>
						    </div>
						 </div> <!-- END: Modal Content -->
						<!-- END: Large Modal Content -->

                        <div class="hidden md:block mx-auto text-slate-500">
                        	Affiche de 1 a 10 sur {{ $services->count() }} services
                        </div>

                        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                            <div class="w-56 relative text-slate-500">
                            	<form id="search-service" action="{{ route('adminSearchService') }}" method="GET" class="d-none">
                            		@csrf
                                	<input type="text" name="q" class="form-control w-56 box pr-10" placeholder="Recherche...">
                                	<a href="" onclick="event.preventDefault(); document.getElementById('search-service').submit();">
	                                	<i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i> 
	                                </a>
                                </form>
                            </div>

                        </div>


                    </div>


                    <br><br>


                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                        <table class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">CODE</th>
                                    <th class="text-center whitespace-nowrap">LIBELLE</th>
                                    <th class="text-center whitespace-nowrap">STATUT</th>
                                    <th class="text-center whitespace-nowrap">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>

                            	@if($services)


	                            	@foreach($services as $service)
	                                <tr class="intro-x">
	                                    <td class="text-center">
	                                    	{{ $service->code }}
	                                    </td>
	                                    <td class="text-center">
	                                    	{{ $service->libelle }}
	                                    </td>
	                                    <td class="w-40">
	                                    	@if($service->active == 1)
	                                        <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Active </div>
	                                        @else
	                                        <div class="flex items-center justify-center text-warning"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Inactive </div>
	                                        @endif
	                                    </td>
	                                    <td class="table-report__action w-56">
	                                        <div class="flex justify-center items-center">
	                                            <a class="flex items-center mr-3" href="javascript:;" data-tw-toggle="modal" data-tw-target="#update-{{ $service->id }}"> <i data-lucide="edit" class="w-4 h-4 mr-1"></i> </a>
	                                        </div>
	                                    </td>
	                                </tr>


	                                <!-- BEGIN: Delete Confirmation Modal -->
						            <div id="update-{{ $service->id }}" class="modal" tabindex="-1" aria-hidden="true">
						                <div class="modal-dialog modal-lg">
									         <div class="modal-content">
									         	<form method="POST" action="{{ route('adminEditService') }}">
									         		@csrf
									             <!-- BEGIN: Modal Header -->
									             <div class="modal-header">
									                 <h2 class="font-medium text-base mr-auto">Formulaire de Modification</h2> 
									             </div> <!-- END: Modal Header -->
									             <!-- BEGIN: Modal Body -->
									             <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

									                 <div class="col-span-12 sm:col-span-6"> 
									                 	<input type="hidden" name="service_id" value="{{ $service->id }}"> 
									                 	<label for="modal-form-1" class="form-label">Code</label> 
									                 	<input type="text" class="form-control" placeholder="FRT" name="code" value="{{ $service->code }}"> 
									                 </div>

									                 <div class="col-span-12 sm:col-span-6"> 
									                 	<label for="modal-form-2" class="form-label">Libelle</label> 
									                 	<input type="text" class="form-control" placeholder="FRET AERIEN" name="libelle" value="{{ $service->libelle }}"> 
									                 </div>

									                
									                 <div class="col-span-12 sm:col-span-12"> 
									                 	<label for="modal-form-2" class="form-label">Description</label> 
									                 	<textarea name="description" class="form-control" rows="4">
									                 		{{ $service->description }}
									                 	</textarea> 
									                 </div>

									                 
									                 <div class="col-span-12 sm:col-span-12"> 
									                 	<label for="modal-form-6" class="form-label">Statut</label> 
									                 	<select id="modal-form-6" class="form-select" name="active">
									                         <option value="1">active</option>
									                         <option value="0">inactif</option>
									                     </select> 
									                 </div>

									             </div> <!-- END: Modal Body -->
									             <!-- BEGIN: Modal Footer -->
									             <div class="modal-footer">
									             	<button type="submit" class="btn btn-primary w-20">Soumettre</button> 
									             </div> 
									             <!-- END: Modal Footer -->
									            </form>
									         </div>
									    </div>
						            </div>
						            <!-- END: Delete Confirmation Modal -->



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
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                        <nav class="w-full sm:w-auto sm:mr-auto">
                            {{ $services->links() }}
                        </nav>
                    </div>
                    <!-- END: Pagination -->
                </div>

            </div>




@endsection