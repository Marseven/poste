@extends('layouts.admin')

@section('page-content')

    <div class="col-span-12 2xl:col-span-12">
        <h2 class="intro-y text-lg font-medium mt-10">
            Liste des pays
        </h2>
        <div class="grid grid-cols-12 gap-12 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#large-modal-size-preview"
                    class="btn btn-primary shadow-md mr-2">Nouveau Pays</a>

                <!-- BEGIN: Large Modal Content -->
                <!-- BEGIN: Modal Content -->
                <div id="large-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('adminAddPays') }}">
                                @csrf
                                <!-- BEGIN: Modal Header -->
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Formulaire d'ajout</h2>
                                </div> <!-- END: Modal Header -->
                                <!-- BEGIN: Modal Body -->
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="modal-form-6" class="form-label">Zone</label>
                                        <select id="modal-form-6" class="form-select" name="zone_id">
                                            @foreach ($zones as $zone)
                                                <option value="{{ $zone->id }}">
                                                    {{ $zone->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-1" class="form-label">Code</label>
                                        <input type="text" class="form-control" placeholder="GA" name="code">
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-2" class="form-label">Libelle</label>
                                        <input type="text" class="form-control" placeholder="GABON" name="libelle">
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
                    Affiche de 1 a 10 sur {{ $countries->count() }} pays
                </div>

                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <form id="search-pays" action="{{ route('adminSearchPays') }}" method="GET" class="d-none">
                            @csrf
                            <input type="text" name="q" class="form-control w-56 box pr-10"
                                placeholder="Recherche...">
                            <a href=""
                                onclick="event.preventDefault(); document.getElementById('search-pays').submit();">
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
                            <th class="whitespace-nowrap">DRAPEAU</th>
                            <th class="whitespace-nowrap text-center">CODE</th>
                            <th class="whitespace-nowrap text-center">ZONE</th>
                            <th class="text-center whitespace-nowrap">NOM</th>
                            <th class="text-center whitespace-nowrap">STATUT</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($countries)
                            @foreach ($countries as $country)
                                @php
                                    $country->load(['zone']);
                                @endphp
                                <tr class="intro-x">
                                    <td class="w-40">
                                        <div class="flex text-center">
                                            <div class="w-10 h-10 image-fit zoom-in text-center">

                                                @if (!empty($country->flag))
                                                    <a class="flex items-center mr-3" href="javascript:;"
                                                        data-tw-toggle="modal" data-tw-target="#flag-{{ $country->id }}">
                                                        <img class="rounded-full text-center" src="{{ $country->flag }}">
                                                    </a>
                                                @else
                                                    <a class="flex items-center mr-3" href="javascript:;"
                                                        data-tw-toggle="modal" data-tw-target="#flag-{{ $country->id }}">
                                                        <img class="rounded-full text-center"
                                                            src="{{ URL::to('avatars/avatar.jpg') }}">
                                                    </a>
                                                @endif

                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        {{ $country->code }}
                                    </td>
                                    <td class="text-center">
                                        {{ $country->zone->libelle }}
                                    </td>
                                    <td class="text-center">
                                        {{ $country->libelle }}
                                    </td>
                                    <td class="w-40">
                                        @if ($country->active == 1)
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                                        @else
                                            <div class="flex items-center justify-center text-warning"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Inactive </div>
                                        @endif
                                    </td>
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3" href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#update-{{ $country->id }}"> <i data-lucide="edit"
                                                    class="w-4 h-4 mr-1"></i> </a>
                                        </div>
                                    </td>
                                </tr>


                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="update-{{ $country->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('adminEditPays') }}">
                                                @csrf
                                                <!-- BEGIN: Modal Header -->
                                                <div class="modal-header">
                                                    <h2 class="font-medium text-base mr-auto">Formulaire de Modification
                                                    </h2>
                                                </div> <!-- END: Modal Header -->
                                                <!-- BEGIN: Modal Body -->
                                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                                    <div class="col-span-12 sm:col-span-12">
                                                        <label for="modal-form-6" class="form-label">Reseau</label>
                                                        <select id="modal-form-6" class="form-select" name="reseau_id">
                                                            @foreach ($zones as $zone)
                                                                @if ($zone->id == $country->zone_id)
                                                                    <option value="{{ $zone->id }}" selected>
                                                                        {{ $zone->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $zone->id }}">
                                                                        {{ $zone->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-span-12 sm:col-span-6">
                                                        <input type="hidden" name="pays_id"
                                                            value="{{ $country->id }}">
                                                        <label for="modal-form-1" class="form-label">Code</label>
                                                        <input type="text" class="form-control" placeholder="GA"
                                                            name="code" value="{{ $country->code }}">
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-2" class="form-label">Libelle</label>
                                                        <input type="text" class="form-control" placeholder="GABON"
                                                            name="libelle" value="{{ $country->libelle }}">
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

                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="flag-{{ $country->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('adminFlagPays') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <!-- BEGIN: Modal Header -->
                                                <div class="modal-header">
                                                    <h2 class="font-medium text-base mr-auto">Formulaire de Modification
                                                    </h2>
                                                </div> <!-- END: Modal Header -->
                                                <!-- BEGIN: Modal Body -->
                                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                                    <div class="col-span-12 sm:col-span-6">
                                                        <input type="hidden" name="pays_id"
                                                            value="{{ $country->id }}">
                                                        <label for="modal-form-1" class="form-label">Drapeau</label>
                                                        <input type="file" class="form-control" name="image">
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
                    {{ $countries->links() }}
                </nav>
            </div>
            <!-- END: Pagination -->
        </div>
    </div>
@endsection
