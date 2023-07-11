@extends('layouts.admin')

@section('page-content')

			<!-- END: Top Bar -->
                <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">
                        Facture Expedition
                    </h2>
                    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                        <a href="{{ route('adminFacturePrint', ['code' => $expedition->code_aleatoire]) }}" class="btn btn-primary shadow-md mr-2" target="_blank">Imprimer</a>
                    </div>
                </div>
                <!-- BEGIN: Invoice -->
                <div class="intro-y box overflow-hidden mt-5">
                    <div class="flex flex-col lg:flex-row pt-10 px-5 sm:px-20 sm:pt-20 lg:pb-20 text-center sm:text-left">
                        <div class="font-semibold text-primary text-3xl">
                        	FACTURE 
                        	<div class="text-xl text-primary font-medium">#{{ $expedition->code_aleatoire }}</div>

                        	@php
							    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
							@endphp
                        	<div class="mt-1">
                                {!! QrCode::size(130)->generate($expedition->code_aleatoire) !!}
                        	</div>
                        </div>
                        <div class="mt-20 lg:mt-0 lg:ml-auto lg:text-right">
                            <div class="text-xl text-primary font-medium">
                            	{{ $societe->name }}
                            </div>
                            <div class="mt-1">{{ $societe->email }}</div>
                            <div class="mt-1">{{ $societe->phone1 }}, {{ $societe->phone2 }}</div>
                            <div class="mt-1">{{ $societe->website }}</div>
                            <div class="mt-1">{{ $societe->adresse }}</div>
                        </div>
                    </div>
                    <div class="flex flex-col lg:flex-row border-b px-5 sm:px-20 pt-10 pb-10 sm:pb-20 text-center sm:text-left">
                        <div>
                            <div class="text-base text-slate-500">Expediteur Details</div>
                            <div class="text-lg font-medium text-primary mt-2">{{ $expedition->name_exp }}</div>
                            <div class="mt-1">{{ $expedition->email_exp }}</div>
                            <div class="mt-1">{{ $expedition->phone_exp }}</div>
                            <div class="mt-1">{{ $expedition->adresse_exp }}</div>
                        </div>
                        <div class="mt-10 lg:mt-0 lg:ml-auto lg:text-right">
                            <div class="text-base text-slate-500">Destinataire Details</div>
                            <div class="text-lg font-medium text-primary mt-2">{{ $expedition->name_dest }}</div>
                            <div class="mt-1">{{ $expedition->email_dest }}</div>
                            <div class="mt-1">{{ $expedition->phone_dest }}</div>
                            <div class="mt-1">{{ $expedition->adresse_dest }}</div>
                        </div>
                    </div>
                    <div class="px-5 sm:px-16 py-10 sm:py-20">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">
                                            LIBELLE
                                        </th>
                                        <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">
                                            TYPE
                                        </th>
                                        <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">
                                            HAUTEUR
                                        </th>
                                        <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">
                                            LONGEUR
                                        </th>
                                        <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">
                                            LARGEUR
                                        </th>
                                        <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">
                                            POIDS
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if($paquets)

                                        @foreach($paquets as $paquet)
                                        <tr>
                                            <td class="border-b dark:border-darkmode-400">
                                                <div class="font-medium whitespace-nowrap">
                                                    {{ $paquet->libelle }}
                                                </div>
                                                <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">
                                                    {{ $paquet->description }}
                                                </div>
                                            </td>
                                            <td class="text-left text-warning border-b dark:border-darkmode-400 w-32">
                                                {{ $paquet->modele }}
                                            </td>
                                            <td class="text-center border-b dark:border-darkmode-400 w-32">
                                                {{ $paquet->hauteur }}
                                            </td>
                                            <td class="text-center border-b dark:border-darkmode-400 w-32">
                                                {{ $paquet->longeur }}
                                            </td>
                                            <td class="text-center border-b dark:border-darkmode-400 w-32">
                                                {{ $paquet->largeur }}
                                            </td>
                                            <td class="text-center border-b dark:border-darkmode-400 w-32">
                                                {{ $paquet->poids }}
                                            </td>
                                        </tr>
                                        @endforeach

                                    @else
                                    <tr>
                                        <td class="border-b dark:border-darkmode-400">
                                            <div class="font-medium whitespace-nowrap">xxxxxxxxxxxxxxxxx</div>
                                            <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">xxxxxxxxxxxxxxx</div>
                                        </td>
                                        <td class="text-right border-b dark:border-darkmode-400 w-32">0</td>
                                        <td class="text-right border-b dark:border-darkmode-400 w-32">0</td>
                                        <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">0</td>
                                    </tr>
                                    @endif
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
                        <div class="text-center sm:text-left mt-10 sm:mt-0">
                            <div class="text-base text-slate-500">Informations supplementaires</div>
                            <div class="mt-1">
                                <strong>Service</strong> : {{ $expedition->service_exp_id ? $expedition->service->libelle : 'Non defini' }} 
                            </div>
                            <div class="mt-1">
                                <strong>Delai de livraison</strong> : {{ $expedition->temps_exp_id ? $expedition->delai->libelle : 'Non defini' }} 
                            </div>
                            <div class="mt-1">
                                <strong>Plage de poids du colis ou paquet</strong> : {{ $expedition->forfait_exp_id ? $expedition->forfait->libelle : 'Non defini' }}
                            </div>

                            <br>

                            <div class="mt-1">
                            	<strong>Date</strong> : {{ \Carbon\Carbon::parse($expedition->created_at)->translatedFormat('l jS F Y') }} 
                            </div>
                            <div class="mt-1">
                            	<strong>Signature Client</strong> : ____________________________________
                            </div>
                        </div>
                        <div class="text-center sm:text-right sm:ml-auto">
                            <div class="text-base text-slate-500">Montant Total</div>
                            <div class="text-xl text-primary font-medium mt-2">{{ $expedition->amount }} XAF</div>
                            <div class="mt-1">Taxes inclues</div>
                        </div>
                    </div>

                    <br>

                    <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
                        <div class="text-center sm:text-left mt-10 sm:mt-0">
                            <div class="text-base text-slate-500"><strong>Conditions</strong></div>
                            <div class="mt-1">
                            	L'expéditeur déclare qu'il n'envoie pas d'argent, d'explosifs, d'armes, de bijoux ou de produits chimiques. En cas de saisie de la marchandise par les autorités douanières, le paiement des taxes sera à la charge du client. {{ $societe->name }} répondra pour la valeur entre 0,00 XAF et 100 000 XAF selon l'évaluation et les critères assignés par l'entreprise. {{ $societe->name }} n'est pas responsable de la casse ou de l'endommagement de la marchandise. Le client autorise l'agent à avoir un contact visuel avec la boîte (revoir) son contenu. 
                            </div>
                        </div>
                    	
                    </div>
                </div>
                <!-- END: Invoice -->




@endsection