@extends('layouts.admin')

@section('page-content')

			<div class="col-span-12 2xl:col-span-12">
				<div class="intro-y flex items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">
                        Details Societe
                    </h2>
                </div>
                <!-- BEGIN: Profile Info -->
                <div class="intro-y box px-5 pt-5 mt-5">
                    <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                <img class="rounded-full" src="{{ !empty($societe->logo) ? $societe->logo : 'assets/dist/images/preview-1.jpg' }}">
                            </div>
                            <div class="ml-5">
                                <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $societe->name }}</div>
                                <div class="text-slate-500">NIF | {{ $societe->immatriculation }}</div>
                            </div>
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                            <div class="font-medium text-center lg:text-left lg:mt-3">Contacts</div>
                            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                                <div class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="mail" class="w-4 h-4 mr-2"></i> {{ $societe->email }} </div>
                                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="phone" class="w-4 h-4 mr-2"></i> {{ $societe->phone1 }}, {{ $societe->phone2 }} </div>
                                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="target" class="w-4 h-4 mr-2"></i> {{ $societe->website }} </div>
                            </div>
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                            <div class="font-medium text-center lg:text-left lg:mt-3">Localisation</div>
                            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                                <div class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i> {{ $societe->ville_id ? $societe->ville->libelle : 'Non defini' }} </div>
                                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="tag" class="w-4 h-4 mr-2"></i> {{ $societe->adresse }} </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-link-tabs flex-col sm:flex-row justify-center lg:justify-start text-center" role="tablist" >
                        <li id="dashboard-tab" class="nav-item" role="presentation"> 
                        	<a href="javascript:;" class="nav-link py-4 active" data-tw-target="#dashboard" aria-controls="dashboard" aria-selected="true" role="tab" > 
                        		Modification 
                        	</a> 
                        </li>

                        <li id="account-and-profile-tab" class="nav-item" role="presentation"> 
                        	<a href="javascript:;" class="nav-link py-4" data-tw-target="#account-and-profile" aria-selected="false" role="tab" > 
                        		Logo
                        	</a> 
                        </li>

                        <li id="activities-tab" class="nav-item" role="presentation"> 
                        	<a href="javascript:;" class="nav-link py-4" data-tw-target="#activities" aria-selected="false" role="tab" > 
                        		Icone 
                        	</a> 
                        </li>
                    </ul>
                </div>
                <!-- END: Profile Info -->

                <div class="intro-y tab-content mt-5">

                    <div id="dashboard" class="tab-pane active" role="tabpanel" aria-labelledby="dashboard-tab">
                        
                        <!-- BEGIN: Top Categories -->
                        <div class="intro-y col-span-12 lg:col-span-6">
                        	<!-- BEGIN: Vertical Form -->
	                        <div class="intro-y box">
	                            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
	                                <h2 class="font-medium text-base mr-auto">
	                                    Formulaire de Modification
	                                </h2>
	                            </div>
	                            <div id="vertical-form" class="p-5">

	                            	<form method="POST" action="{{ route('adminEditSociete') }}">

	                            		@csrf

		                                <div class="preview">

		                                    <input type="hidden" name="societe_id" value="{{ $societe->id }}">

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Code</label>
		                                        <input type="text" class="form-control" placeholder="LAPDG" name="code" value="{{ $societe->code }}">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Libelle</label>
		                                        <input type="text" class="form-control" placeholder="La Poste" name="name" value="{{ $societe->name }}">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Email</label>
		                                        <input type="text" class="form-control" placeholder="lapostedugabon@contact.ga" name="email" value="{{ $societe->email }}">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Telephone 1</label>
		                                        <input type="text" class="form-control" placeholder="+241 66 23 23 23" name="phone1" value="{{ $societe->phone1 }}">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Telephone 2</label>
		                                        <input type="text" class="form-control" placeholder="+241 74 22 22 22" name="phone2" value="{{ $societe->phone2 }}">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Site Web</label>
		                                        <input type="text" class="form-control" placeholder="https://www.laposte-du-gabon.ga" name="website" value="{{ $societe->website }}">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Fax</label>
		                                        <input type="text" class="form-control" placeholder="+241 74 00 05 05" name="fax" value="{{ $societe->fax }}">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Adresse</label>
		                                        <input type="text" class="form-control" placeholder="Face Pharmacie Oloumi" name="adresse" value="{{ $societe->adresse }}">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Immatriculation</label>
		                                        <input type="text" class="form-control" placeholder="R9882HR" name="immatriculation" value="{{ $societe->immatriculation }}">
		                                    </div>

		                                    <br>

		                                    <div class="col-span-12 sm:col-span-12"> 
							                 	<label for="modal-form-6" class="form-label">Ville</label> 
							                 	<select id="modal-form-6" class="form-select" name="ville_id">
							                 		@foreach($villes as $ville)
							                        <option value="{{ $ville->id }}">{{ $ville->libelle }}</option>
							                        @endforeach
							                     </select> 
							                 </div>
		                                    
		                                    <button type="submit" class="btn btn-primary mt-5">Soumettre</button>

		                                </div>

		                            </form>

	                            </div>
	                        </div>
	                        <!-- END: Vertical Form -->
                        </div>
                        <!-- END: Top Categories -->

                    </div>

                    <div id="account-and-profile" class="tab-pane" role="tabpanel" aria-labelledby="account-and-profile-tab">
                        
                        <!-- BEGIN: Top Categories -->
                        <div class="intro-y col-span-12 lg:col-span-6">
                        	<!-- BEGIN: Vertical Form -->
	                        <div class="intro-y box">
	                            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
	                                <h2 class="font-medium text-base mr-auto">
	                                    Formulaire de Modification du Logo
	                                </h2>
	                            </div>
	                            <div id="vertical-form" class="p-5">

	                            	<form method="POST" action="{{ route('adminLogoSociete') }}" enctype="multipart/form-data">

	                            		@csrf

		                                <div class="preview">

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Logo</label>
		                                        <input type="hidden" name="societe_id" value="{{ $societe->id }}">
		                                        <input type="file" class="form-control" name="image">
		                                    </div>

		                                    <br>
		                                    
		                                    <button type="submit" class="btn btn-primary mt-5">Soumettre</button>

		                                </div>

		                            </form>

	                            </div>
	                        </div>
	                        <!-- END: Vertical Form -->
                        </div>
                        <!-- END: Top Categories -->
                    	
                    </div>

                    <div id="activities" class="tab-pane" role="tabpanel" aria-labelledby="activities-tab">
                        
                        <!-- BEGIN: Top Categories -->
                        <div class="intro-y col-span-12 lg:col-span-6">
                        	<!-- BEGIN: Vertical Form -->
	                        <div class="intro-y box">
	                            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
	                                <h2 class="font-medium text-base mr-auto">
	                                    Formulaire de Modification du Logo
	                                </h2>
	                            </div>
	                            <div id="vertical-form" class="p-5">

	                            	<form method="POST" action="{{ route('adminIconSociete') }}" enctype="multipart/form-data">

	                            		@csrf

		                                <div class="preview">

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Logo</label>
		                                        <input type="hidden" name="societe_id" value="{{ $societe->id }}">
		                                        <input type="file" class="form-control" name="image">
		                                    </div>

		                                    <br>
		                                    
		                                    <button type="submit" class="btn btn-primary mt-5">Soumettre</button>

		                                </div>

		                            </form>

	                            </div>
	                        </div>
	                        <!-- END: Vertical Form -->
                        </div>
                        <!-- END: Top Categories -->
                    	
                    </div>

                </div>
				
			</div>




@endsection