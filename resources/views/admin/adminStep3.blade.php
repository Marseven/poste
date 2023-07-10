@extends('layouts.admin')

@section('page-content')



	            <div class="intro-y flex items-center mt-8">
	                <h2 class="text-lg font-medium mr-auto">
	                    Nouvelle Expedition - etape III
	                </h2>
	            </div>


                <div class="grid grid-cols-12 gap-6 mt-5">
                    <!-- BEGIN: Profile Menu -->
                    <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">

                    	<div class="intro-y box mt-5 lg:mt-0">
                            <div class="relative flex items-center p-5">
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium text-base">Expedition</div>
                                    <div class="text-slate-500">
                                    	<strong><u>NB</u></strong> : Si vous avez parfaitement rempli ou saisi toutes les informations, valider l'expedition en appuyant sur le bouton <strong>Soumettre</strong> ou sur le bouton <strong>Annuler</strong> pour tout simplement interrompre l'operation.
                                    	<br>
                                    	Si vous le client n'a aucun document a fournir, passer a l'etape suivante !
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400 flex">
                                <a href="{{ route('adminStep2', ['code' => $code]) }}" class="btn btn-lg btn-outline-secondary py-1 px-2 ml-auto">Precedent</a>
                                <a href="{{ route('adminStep4', ['code' => $code]) }}" class="btn btn-lg btn-primary py-1 px-2 ml-auto">Suivant</a>
                            </div>
                        </div>

                    	<div class="intro-y box p-5 bg-primary text-white mt-5">
                            <div class="flex items-center">
                                <div class="font-medium text-lg">Etapes a suivre par l'operateur de saisi ou l'agent</div>
                            </div>
                            <div class="mt-4">
                            	1. Expediteur & Destinataire <br>
                            	2. Informations sur la livraison <br>
                            	3. Ajout des pieces jointes <br>
                            	4. Informations sur le(s) colis ou paquet(s) <br>
                            </div>
                            
                        </div>
                        
                        <div class="intro-y box p-5 bg-primary text-white mt-5">
                            <div class="flex items-center">
                                <div class="font-medium text-lg">Important</div>
                            </div>
                            <div class="mt-4">Les expeditions passees en agence beneficient d'une reduction de 2 % sur le montant a payer.</div>
                            
                        </div>
                    </div>
                    <!-- END: Profile Menu -->
                    <div class="col-span-12 lg:col-span-8 2xl:col-span-9">

                        <div class="grid grid-cols-12 gap-6">

                        	<!-- BEGIN: Daily Sales -->
                            <div class="intro-y box col-span-12 2xl:col-span-12">
                                <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="col-span-12 sm:col-span-12"> 
					                 	<label for="modal-form-1" class="form-label">Code d'expedition</label> 
					                 	<input type="text" readonly class="form-control" name="code_aleatoire" value="{{ $code }}"> 
					                </div>
                                </div>
                            </div>
                            <!-- END: Daily Sales -->


                            <!-- BEGIN: Daily Sales -->
                            <div class="intro-y box col-span-12 2xl:col-span-12">
                                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                                    <h2 class="font-medium text-base mr-auto">
                                        Soumission de pieces jointes
                                    </h2>

                                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#large-modal-size-preview" class="btn btn-outline-secondary hidden sm:flex"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Pieces jointes </a>
                                </div>
                                <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">

                                	@if(!empty($documents))

                                	@foreach($documents as $document)

		                            <div class="intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
		                                <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
		                                    <a href="" class="w-3/5 file__icon file__icon--empty-directory mx-auto"></a> <a href="" class="block font-medium mt-4 text-center truncate">{{ $document->libelle }}</a> 
		                                    <div class="text-slate-500 text-xs text-center mt-0.5">{{ $document->code }}</div>
		                                    <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
		                                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-vertical" class="w-5 h-5 text-slate-500"></i> </a>
		                                        <div class="dropdown-menu w-40">
		                                            <ul class="dropdown-content">
		                                                <li>
		                                                    <a href="" class="dropdown-item"> <i data-lucide="trash" class="w-4 h-4 mr-2"></i> Supprimer </a>
		                                                </li>
		                                            </ul>
		                                        </div>
		                                    </div>
		                                </div>
		                            </div>

		                            @endforeach

		                            @else
		                            @endif

                                </div>
                            </div>
                            <!-- END: Daily Sales -->




                        </div>
                    </div>
                </div>


				<!-- BEGIN: Modal Content -->
				<div id="large-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
				    <div class="modal-dialog modal-lg">
				         <div class="modal-content">
				         	<form id="document-form" method="POST" action="{{ route('adminNewDocument') }}" enctype="multipart/form-data">
				         		@csrf
				             <!-- BEGIN: Modal Header -->
				             <div class="modal-header">
				                 <h2 class="font-medium text-base mr-auto">Formulaire d'ajout d'une piece jointe</h2> 
				             </div> <!-- END: Modal Header -->
				             <!-- BEGIN: Modal Body -->
				             <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
				                 <div class="col-span-12 sm:col-span-6"> 
				                 	<label for="modal-form-1" class="form-label">Code</label> 
				                 	<input type="text" class="form-control" readonly name="code" value="{{ $code }}"> 
				                 </div>

				                 <div class="col-span-12 sm:col-span-6"> 
				                 	<label for="modal-form-2" class="form-label">Nom de la piece</label> 
				                 	<input type="text" class="form-control" placeholder="Manifeste" name="libelle"> 
				                 </div>

				                 <div class="col-span-12 sm:col-span-12"> 
				                 	<label for="modal-form-2" class="form-label">Piece jointe</label> 
				                 	<input type="file" class="form-control" name="image"> 
				                 </div>

				                 

				             </div> <!-- END: Modal Body -->
				             <!-- BEGIN: Modal Footer -->
				             <div class="modal-footer">
				             	<button type="submit" class="btn btn-lg btn-primary py-1 px-2 ml-auto">Soumettre</button> 
				             </div> 
				             <!-- END: Modal Footer -->
				            </form>
				         </div>
				    </div>
				 </div> <!-- END: Modal Content -->
				<!-- END: Large Modal Content -->


			




@endsection