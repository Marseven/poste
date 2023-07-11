@extends('layouts.admin')

@section('page-content')

			<div class="col-span-12 2xl:col-span-12">
				<div class="intro-y flex items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">
                        Mon Profil
                    </h2>
                </div>
                <!-- BEGIN: Profile Info -->
                <div class="intro-y box px-5 pt-5 mt-5">
                    <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                <img class="rounded-full" src="{{ !empty($admin->avatar) ? $admin->avatar : 'assets/dist/images/preview-1.jpg' }}">
                            </div>
                            <div class="ml-5">
                                <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $admin->name }}</div>
                                <div class="text-slate-500">{{ $admin->role }}</div>
                            </div>
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                            <div class="font-medium text-center lg:text-left lg:mt-3">Contacts</div>
                            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                                <div class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="mail" class="w-4 h-4 mr-2"></i> {{ $admin->email }} </div>
                                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="phone" class="w-4 h-4 mr-2"></i> {{ $admin->phone }} </div>
                            </div>
                        </div>
                        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                            <div class="font-medium text-center lg:text-left lg:mt-3">Localisation</div>
                            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="tag" class="w-4 h-4 mr-2"></i> {{ $admin->adresse }} </div>
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
                        		Avatar
                        	</a> 
                        </li>

                        <li id="activities-tab" class="nav-item" role="presentation"> 
                        	<a href="javascript:;" class="nav-link py-4" data-tw-target="#activities" aria-selected="false" role="tab" > 
                        		Mot de Passe 
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

	                            	<form method="POST" action="{{ route('adminUpProfil') }}">

	                            		@csrf

		                                <div class="preview">

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Noms</label>
		                                        <input type="text" class="form-control" placeholder="Ex. MEZUI" name="noms" value="{{ $admin->noms }}">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Prenoms</label>
		                                        <input type="text" class="form-control" placeholder="Ex. Alex" name="prenoms" value="{{ $admin->prenoms }}">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Email</label>
		                                        <input type="text" class="form-control" placeholder="admin@contact.ga" name="email" value="{{ $admin->email }}">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Telephone </label>
		                                        <input type="text" class="form-control" placeholder="+241 66 23 23 23" name="phone" value="{{ $admin->phone }}">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Adresse</label>
		                                        <input type="text" class="form-control" placeholder="Face Pharmacie Oloumi" name="adresse" value="{{ $admin->adresse }}">
		                                    </div>

		                                    <br>

		                                    <div class="col-span-12 sm:col-span-12"> 
							                 	<label for="modal-form-6" class="form-label">Agence</label> 
							                 	<select id="modal-form-6" class="form-select" name="agence_id">
							                 		@foreach($agences as $agence)
							                        <option value="{{ $agence->id }}">{{ $agence->libelle }}</option>
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
	                                    Formulaire de Modification de votre Avatar
	                                </h2>
	                            </div>
	                            <div id="vertical-form" class="p-5">

	                            	<form method="POST" action="{{ route('adminUpAvatar') }}" enctype="multipart/form-data">

	                            		@csrf

		                                <div class="preview">

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Avatar</label>
		                                        <input type="file" class="form-control" name="avatar">
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
	                                    Formulaire de Modification de votre Mot de Passe
	                                </h2>
	                            </div>
	                            <div id="vertical-form" class="p-5">

	                            	<form method="POST" action="{{ route('adminUpPassword') }}" enctype="multipart/form-data">

	                            		@csrf

		                                <div class="preview">

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Ancien Mot de Passe</label>
		                                        <input type="text" class="form-control" name="old_password">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Nouveau Mot de Passe</label>
		                                        <input type="text" class="form-control" name="new_password">
		                                    </div>

		                                    <br>

		                                    <div>
		                                        <label for="vertical-form-1" class="form-label">Confirmation Mot de Passe</label>
		                                        <input type="text" class="form-control" name="confirm_password">
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