@extends('layouts.admin')

@section('page-content')

    <div class="col-span-12 2xl:col-span-12">
        <h2 class="intro-y text-lg font-medium mt-10">
            Expeditions
        </h2>
        <div class="grid grid-cols-12 gap-12 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

                <div class="hidden md:block mx-auto text-slate-500">
                    Affiche de 1 a 10 sur {{ $expeditions->count() }} expéditions
                </div>

                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <form id="search-forfait" action="" method="GET" class="d-none">
                            @csrf
                            <input type="text" name="q" class="form-control w-56 box pr-10"
                                placeholder="Recherche...">
                            <a href=""
                                onclick="event.preventDefault(); document.getElementById('search-Tarif').submit();">
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
                            <th class="whitespace-nowrap text-center">SUIVI</th>
                            <th class="text-center whitespace-nowrap">DATE</th>
                            <th class="text-center whitespace-nowrap">EXPEDITEUR</th>
                            <th class="text-center whitespace-nowrap">DESTINATAIRE</th>
                            <th class="text-center whitespace-nowrap">COUT TOTAL</th>
                            <th class="text-center whitespace-nowrap">STATUT FACTURE</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($expeditions)
                            @foreach ($expeditions as $expedition)
                                <tr class="intro-x">
                                    <td class="text-center bg-primary">
                                        <a class="text-primary"
                                            href="{{ route('adminSuiviExpedition', ['code' => $expedition->code_aleatoire]) }}">
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
                                        {{ $expedition->amount ? $expedition->amount : 0 }} XAF
                                    </td>
                                    <td class="w-40">
                                        @if ($expedition->active == 1)
                                            <div class="flex items-center justify-center text-warning"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> En attente de
                                                paiement </div>
                                        @elseif($expedition->active == 2)
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Paye(e) </div>
                                        @elseif($expedition->active == 3)
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> CNT </div>
                                        @elseif($expedition->active == 4)
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Livre(e) </div>
                                        @else
                                            <div class="flex items-center justify-center text-warning"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Inactive </div>
                                        @endif
                                    </td>
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <div class="dropdown">
                                                <button class="dropdown-toggle btn btn-warning" aria-expanded="false"
                                                    data-tw-toggle="dropdown">Actions
                                                </button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        @if ($expedition->active == 1)
                                                            <li>
                                                                <a href="{{ route('adminFacturePay', ['code' => $expedition->code_aleatoire]) }}"
                                                                    class="dropdown-item">Ajouter un
                                                                    paiement</a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a href="{{ route('adminFactureExpedition', ['code' => $expedition->code_aleatoire]) }}"
                                                                class="dropdown-item">Facture</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('adminEtiquetteExpedition', ['code' => $expedition->code_aleatoire]) }}"
                                                                class="dropdown-item">Etiquette</a>
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
            <!-- END: Data List -->
            <!-- BEGIN: Pagination -->
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                <nav class="w-full sm:w-auto sm:mr-auto">
                    {{ $expeditions->links() }}
                </nav>
            </div>
            <!-- END: Pagination -->
        </div>

    </div>
@endsection
