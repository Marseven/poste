@extends('layouts.admin')

@section('page-content')
    <div class="col-span-12 2xl:col-span-12">
        <h2 class="intro-y text-lg font-medium mt-10">
            Liste des réclamations agent
        </h2>
        <div class="grid grid-cols-12 gap-12 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

                <div class="hidden md:block mx-auto text-slate-500">
                    Affiche de 1 a 10 sur {{ $reclamations->count() }} Réclamations
                </div>

                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <form id="search-reclamation-agent" action="{{ route('adminSearchReclamationAgent') }}" method="GET"
                            class="d-none">
                            @csrf
                            <input type="text" name="q" class="form-control w-56 box pr-10"
                                placeholder="Recherche...">
                            <a href=""
                                onclick="event.preventDefault(); document.getElementById('search-reclamation-agent').submit();">
                                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                            </a>
                        </form>
                    </div>

                </div>


            </div>


            <br><br>


            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto ">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">CODE</th>
                            <th class="whitespace-nowrap text-center">LIBELLE</th>
                            <th class="text-center whitespace-nowrap">AUTEUR</th>
                            <th class="text-center whitespace-nowrap">ELEMENT</th>
                            <th class="text-center whitespace-nowrap">STATUT</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($reclamations->count() > 0)
                            @foreach ($reclamations as $reclamation)
                                @php
                                    $reclamation->load(['expedition', 'package', 'colis', 'agent']);
                                @endphp
                                <tr class="intro-x">
                                    <td class="w-40">
                                        {{ $reclamation->code }}
                                    </td>
                                    <td class="text-center">
                                        {{ $reclamation->libelle }}
                                    </td>
                                    <td class="text-center">
                                        {{ $reclamation->agent ? $reclamation->agent->noms . ' ' . $reclamation->agent->prenoms : '' }}
                                    </td>
                                    <td class="text-center">
                                        @if ($reclamation->expedition_id != null)
                                            Expédition N° {{ $reclamation->expedition->code }}
                                        @elseif($reclamation->package_id != null)
                                            Package N° {{ $reclamation->package->code }}
                                        @else
                                            Colis N° {{ $reclamation->colis->code ?? '' }}
                                        @endif
                                    </td>
                                    <td class="w-40">
                                        @if ($reclamation->status == 0)
                                            <div class="flex items-center justify-center text-primary"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Enregistré </div>
                                        @elseif($reclamation->status == 1)
                                            <div class="flex items-center justify-center text-warning"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> En cours de
                                                traitement </div>
                                        @else
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Traité </div>
                                        @endif
                                    </td>
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3" href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#update-{{ $reclamation->id }}"> <i data-lucide="edit"
                                                    class="w-4 h-4 mr-1"></i> </a>
                                        </div>

                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3" href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#view-{{ $reclamation->id }}"> <i data-lucide="eye"
                                                    class="w-4 h-4 mr-1"></i> </a>
                                        </div>
                                    </td>
                                </tr>


                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="update-{{ $reclamation->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('adminEditReclamation') }}">
                                                @csrf
                                                <!-- BEGIN: Modal Header -->
                                                <div class="modal-header">
                                                    <h2 class="font-medium text-base mr-auto">Formulaire de Modification
                                                    </h2>
                                                </div> <!-- END: Modal Header -->
                                                <!-- BEGIN: Modal Body -->
                                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                                    <input type="hidden" name="reclamation_id"
                                                        value="{{ $reclamation->id }}">
                                                    <div class="col-span-12 sm:col-span-12">
                                                        <label for="modal-form-6" class="form-label">Statut</label>
                                                        <select id="modal-form-6" class="form-select" name="status">
                                                            <option value="1">En Cours de Traitement</option>
                                                            <option value="2">Traité</option>
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

                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="view-{{ $reclamation->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <!-- BEGIN: Modal Header -->
                                            <div class="modal-header">
                                                <h2 class="font-medium text-base mr-auto">Réclamation N°
                                                    {{ $reclamation->code }}
                                                </h2>
                                            </div> <!-- END: Modal Header -->

                                            <!-- BEGIN: Modal Body -->
                                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                                <div class="row">
                                                    <div class="col-6 mb-5">
                                                        <h6 class="text-uppercase fs-5 ls-2">LIBELLE </h6>
                                                        <p class="mb-0">{{ $reclamation->libelle }}</p>
                                                    </div>
                                                    <div class="col-6 mb-5">
                                                        <h6 class="text-uppercase fs-5 ls-2">AUTEUR </h6>
                                                        <p class="mb-0">
                                                            {{ $reclamation->agent->noms . ' ' . $reclamation->agent->prenoms }}
                                                        </p>
                                                    </div>

                                                    <div class="col-6 mb-5">
                                                        <h6 class="text-uppercase fs-5 ls-2">DETAILS </h6>
                                                        <p class="mb-0">
                                                            {{ $reclamation->details }}
                                                        </p>
                                                    </div>

                                                    <div class="col-6 mb-5">
                                                        <h6 class="text-uppercase fs-5 ls-2">ELEMENT </h6>
                                                        @if ($reclamation->expedition_id != null)
                                                            <p>Expédition N° {{ $reclamation->expedition->code }}</p>
                                                        @elseif($reclamation->package_id != null)
                                                            <p>Package N° {{ $reclamation->package->code }}</p>
                                                        @else
                                                            <p>Colis N° {{ $reclamation->colis->code }}</p>
                                                        @endif
                                                    </div>

                                                    <div class="col-6 mb-5">
                                                        <h6 class="text-uppercase fs-5 ls-2">STATUT</h6>
                                                        <p class="mb-0">
                                                            @if ($reclamation->status == 0)
                                                                <span class="text-md px-1 bg-primary text-white mr-1"
                                                                    style="padding:5px; font-weight: 600;">Enregistré
                                                                </span>
                                                            @elseif($reclamation->status == 1)
                                                                <span class="text-md px-1 bg-warning text-white mr-1"
                                                                    style="padding:5px; font-weight: 600;">En cours de
                                                                    traitement
                                                                </span>
                                                            @else
                                                                <span class="text-md px-1 bg-success text-white mr-1"
                                                                    style="padding:5px; font-weight: 600;">Traité
                                                                </span>
                                                            @endif

                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END: Modal Body -->
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Delete Confirmation Modal -->
                            @endforeach
                        @endif

                    </tbody>
                </table>
                @if ($reclamations->count() == 0)
                    <div class="col-span-12 2xl:col-span-12">
                        <div class="alert alert-pending alert-dismissible show flex items-center mb-2" role="alert"> <i
                                data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i> Aucun élément pour le
                            moment
                            ! </div>
                    </div>
                @endif
            </div>
            <!-- END: Data List -->
            <!-- BEGIN: Pagination -->
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                <nav class="w-full sm:w-auto sm:mr-auto">
                    {{ $reclamations->links() }}
                </nav>
            </div>
            <!-- END: Pagination -->
        </div>
    </div>
@endsection
