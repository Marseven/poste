@extends('layouts.admin')

@section('page-content')

			<form id="global-form" method="POST" action="{{ route('adminNewStep1') }}">

				@csrf

	            <div class="intro-y flex items-center mt-8">
	                <h2 class="text-lg font-medium mr-auto">
	                    Nouvelle Expedition - Etape I
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
                                    	<strong><u>NB</u></strong> : Si vous avez parfaitement rempli ou saisi toutes les informations, valider l'expedition en appuyant sur le bouton <strong>Suivant</strong> ou sur le bouton <strong>Annuler</strong> pour tout simplement interrompre l'operation.
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400 flex">
                                <button type="button" class="btn btn-lg btn-outline-secondary py-1 px-2 ml-auto">Annuler</button>
                                <button type="submit" class="btn btn-lg btn-primary py-1 px-2 ml-auto">Suivant</button>
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
                                    <div class="col-span-12 sm:col-span-6"> 
					                 	<label for="modal-form-1" class="form-label">Code d'expedition</label> 
					                 	<input type="text" readonly class="form-control" name="code_aleatoire" value="{{ $code_aleatoire }}"> 
					                 </div>
                                    <div class="col-span-12 sm:col-span-6"> 
					                 	<label for="modal-form-1" class="form-label">Agence</label> 
					                 	<select class="form-control" name="agence_id" required name="agence_id">
					                 		@foreach($agences as $agence)
					                 		<option value="{{ $agence->id }}">{{ $agence->code }}, {{ $agence->libelle }}</option>
					                 		@endforeach
					                 	</select>
					                 </div>
                                </div>
                            </div>
                            <!-- END: Daily Sales -->

                            <!-- BEGIN: Daily Sales -->
                            <div class="intro-y box col-span-12 2xl:col-span-6">
                                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                                    <h2 class="font-medium text-base mr-auto">
                                        Expediteur
                                    </h2>
                                </div>
                                <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="col-span-12 sm:col-span-12"> 
					                 	<label for="modal-form-1" class="form-label">Nom complet*</label> 
					                 	<input type="text" class="form-control" placeholder="Ex. Paul NDONG" name="name_exp" required> 
					                </div>
                                    <div class="col-span-12 sm:col-span-12">  
					                 	<label for="modal-form-1" class="form-label">Email</label> 
					                 	<input type="text" class="form-control" placeholder="Ex. paul.ndong@gmail.com" name="email_exp"> 
					                </div>
                                    <div class="col-span-12 sm:col-span-12">  
					                 	<label for="modal-form-1" class="form-label">Telephone*</label> 
					                 	<input type="text" class="form-control" placeholder="Ex. +241 74 00 00 01" name="phone_exp" required> 
					                </div>
                                    <div class="col-span-12 sm:col-span-12"> 
					                 	<label for="modal-form-1" class="form-label">Adresse*</label> 
					                 	<input type="text" class="form-control" placeholder="Ex. Face CKDO Oloumi" name="adresse_exp" required> 
					                </div>
                                </div>
                            </div>
                            <!-- END: Daily Sales -->

                            <!-- BEGIN: Daily Sales -->
                            <div class="intro-y box col-span-12 2xl:col-span-6">
                                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                                    <h2 class="font-medium text-base mr-auto">
                                        Destinataire
                                    </h2>
                                </div>
                                <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="col-span-12 sm:col-span-12">  
					                 	<label for="modal-form-1" class="form-label">Nom complet*</label> 
					                 	<input type="text" class="form-control" placeholder="Ex. Arnaud MEZUI" name="name_dest" required> 
					                </div>
                                    <div class="col-span-12 sm:col-span-12"> 
					                 	<label for="modal-form-1" class="form-label">Email</label> 
					                 	<input type="text" class="form-control" placeholder="Ex. mezui.a@gmail.com" name="email_dest"> 
					                </div>
                                    <div class="col-span-12 sm:col-span-12">  
					                 	<label for="modal-form-1" class="form-label">Telephone*</label> 
					                 	<input type="text" class="form-control" placeholder="Ex. +241 66 00 00 02" name="phone_dest" required> 
					                </div>
                                    <div class="col-span-12 sm:col-span-12">  
					                 	<label for="modal-form-1" class="form-label">Adresse*</label> 
					                 	<input type="text" class="form-control" placeholder="Ex. Rond point democratie" name="adresse_dest" required> 
					                 	<small>NB : <strong>Cette adresse est celle ou sera livre le colis !</strong></small>
					                </div>
                                </div>
                            </div>
                            <!-- END: Daily Sales -->

                            

                            



                        </div>
                    </div>
                </div>


				

			</form>

			




@endsection