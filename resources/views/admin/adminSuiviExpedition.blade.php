@extends('layouts.admin')

@section('page-content')

    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Suivi Expedition
        </h2>
    </div>
    <!-- BEGIN: Invoice -->
    <div class="intro-y box overflow-hidden mt-5">
        <div class="flex flex-col lg:flex-row pt-10 px-5 sm:px-20 sm:pt-20 lg:pb-20 text-center sm:text-left">
            <div class="font-semibold text-primary text-3xl">
                SUIVI
                <div class="text-xl text-primary font-medium">#{{ $expedition->code_aleatoire }}</div>

                @php
                    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                @endphp
                <div class="mt-1">
                    {!! $generator->getBarcode($expedition->code_aleatoire, $generator::TYPE_CODE_128) !!}
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
                            <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">LIBELLE</th>
                            <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">DESCRIPTION</th>
                            <th class="border-b-2 dark:border-darkmode-400  whitespace-nowrap">POIDS</th>
                            <th class="border-b-2 dark:border-darkmode-400  whitespace-nowrap">PRIX</th>
                            <th class="border-b-2 dark:border-darkmode-400  whitespace-nowrap">STATUT</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($paquets)
                            @foreach ($paquets as $paquet)
                                @php
                                    $paquet->load(['price']);
                                @endphp
                                <tr>
                                    <td class="border-b dark:border-darkmode-400">
                                        <div class="font-medium whitespace-nowrap">
                                            <a href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#paquet-{{ $paquet->id }}">
                                                {{ $paquet->libelle }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-left border-b dark:border-darkmode-400 w-32">
                                        <div class="font-medium whitespace-nowrap">
                                            {{ $paquet->description }}
                                        </div>
                                    </td>
                                    <td class="text-left border-b dark:border-darkmode-400 w-32">
                                        {{ $paquet->price->weight }} KG(s)
                                    </td>
                                    <td class="text-left border-b dark:border-darkmode-400 w-32">
                                        {{ $paquet->price->price }} FCFA
                                    </td>
                                    <td class="text-left border-b dark:border-darkmode-400 w-32">
                                        @if ($paquet->active == 1)
                                            <div class="flex items-center justify-center text-warning"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Enregistre(e)
                                            </div>
                                        @elseif($paquet->active == 2)
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Assigne(e) </div>
                                        @elseif($paquet->active == 3)
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> CNT </div>
                                        @elseif($paquet->active == 4)
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Expedie(e) </div>
                                        @elseif($paquet->active == 5)
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Livre(e) </div>
                                        @else
                                            <div class="flex items-center justify-center text-warning"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Non defini </div>
                                        @endif
                                    </td>
                                </tr>

                                <!-- BEGIN: Modal Content -->
                                <div id="paquet-{{ $paquet->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <!-- BEGIN: Modal Header -->
                                            <div class="modal-header">
                                                <h2 class="font-medium text-base mr-auto">QR CODE</h2>
                                            </div> <!-- END: Modal Header -->
                                            <!-- BEGIN: Modal Body -->
                                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                                <div class="col-span-12 sm:col-span-12">
                                                    <center>
                                                        {!! QrCode::size(250)->generate($paquet->id) !!}
                                                    </center>
                                                </div>
                                                <br><br>

                                            </div> <!-- END: Modal Body -->
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Modal Content -->
                                <!-- END: Large Modal Content -->
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
                    <strong>Service</strong> :
                    {{ $expedition->service_exp_id ? $expedition->service->libelle : 'Non defini' }}
                </div>
                <div class="mt-1">
                    <strong>Type d'expédition</strong> :
                    {{ $expedition->type_exp_id ? $expedition->type->libelle : 'Non defini' }}
                </div>
                <div class="mt-1">
                    <strong>Régime d'expédition</strong> :
                    {{ $expedition->regime_exp_id ? $expedition->regime->libelle : 'Non defini' }}
                </div>
                <div class="mt-1">
                    <strong>Catégorie d'expédition</strong> :
                    {{ $expedition->category_exp_id ? $expedition->category->libelle : 'Non defini' }}
                </div>
                <div class="mt-1">
                    <strong>Statut Facture</strong> :
                </div>
                <div class="mt-1">
                    <strong>Statut Colis</strong> :
                </div>

                <br>

                <div class="mt-1">
                    <strong>Date</strong> :
                    {{ \Carbon\Carbon::parse($expedition->created_at)->translatedFormat('l jS F Y') }}
                </div>
            </div>
            <div class="text-center sm:text-right sm:ml-auto">
                <div class="text-base text-slate-500">Montant Total</div>
                <div class="text-xl text-primary font-medium mt-2">{{ $expedition->amount }} FCFA</div>
                <div class="mt-1">Taxes inclues</div>
            </div>
        </div>

        <br><br>

        <div class="px-5 sm:px-20 pb-10 sm:pb-20">
            <br><br>
            <h2 class="text-lg font-medium mr-auto">
                HISTORIQUE
            </h2>

            <br><br>

            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">
                                DATE
                            </th>
                            <th class="whitespace-nowrap">
                                EMPLACEMENT
                            </th>
                            <th class="text-center whitespace-nowrap">
                                STATUT COLIS
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($historiques)
                            @foreach ($historiques as $historique)
                                <tr class="intro-x">
                                    <td class="">
                                        {{ \Carbon\Carbon::parse($historique->created_at)->translatedFormat('l jS F Y') }}
                                    </td>
                                    <td class="text-left">
                                        {{ $historique->action }}
                                    </td>
                                    <td class="text-center text-right">
                                        @if ($historique->active == 1)
                                            <div class="flex items-center justify-center text-warning"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> En attente de
                                                paiement
                                            </div>
                                        @elseif($historique->active == 2)
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> En attente de
                                                livraison
                                            </div>
                                        @elseif($historique->active == 3)
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> CNT </div>
                                        @elseif($historique->active == 4)
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Livre(e) </div>
                                        @else
                                            <div class="flex items-center justify-center text-warning"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Inactive </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center border-b dark:border-darkmode-400 w-32">0</td>
                                <td class="text-center border-b dark:border-darkmode-400 w-32">0</td>
                                <td class="text-center border-b dark:border-darkmode-400 w-32 font-medium">0</td>
                            </tr>
                        @endif


                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->
        </div>

    </div>
    <!-- END: Invoice -->

@endsection
