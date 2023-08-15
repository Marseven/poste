@extends('layouts.admin')

@section('page-content')

    <div class="col-span-12 2xl:col-span-12">
        <h2 class="intro-y text-lg font-medium mt-10">
            Tarifs d'expedition
        </h2>
        <div class="grid grid-cols-12 gap-12 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#large-modal-size-preview"
                    class="btn btn-primary shadow-md mr-2">Nouveau Tarif</a>

                <!-- BEGIN: Large Modal Content -->
                <!-- BEGIN: Modal Content -->
                <div id="large-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('adminAddTarif') }}">
                                @csrf
                                <!-- BEGIN: Modal Header -->
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Formulaire d'ajout</h2>
                                </div> <!-- END: Modal Header -->
                                <!-- BEGIN: Modal Body -->
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="modal-form-1" class="form-label">Code</label>
                                        <input type="text" class="form-control" placeholder="T000001" name="code">
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-6" class="form-label">Pays Origine</label>
                                        <select id="modal-form-6" class="form-select" name="pays_exp">
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->libelle }}">{{ $country->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-6" class="form-label">Province Origine</label>
                                        <select id="modal-form-6" class="form-select" name="province_exp">
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->libelle }}">{{ $province->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-6" class="form-label">Ville Origine</label>
                                        <select id="modal-form-6" class="form-select" name="ville_exp">
                                            @foreach ($villes as $ville)
                                                <option value="{{ $ville->libelle }}">{{ $ville->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-6" class="form-label">Pays Destination</label>
                                        <select id="modal-form-6" class="form-select" name="pays_dest">
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->libelle }}">{{ $country->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-6" class="form-label">Province Destination</label>
                                        <select id="modal-form-6" class="form-select" name="province_dest">
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->libelle }}">{{ $province->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-6" class="form-label">Ville Destination</label>
                                        <select id="modal-form-6" class="form-select" name="ville_dest">
                                            @foreach ($villes as $ville)
                                                <option value="{{ $ville->libelle }}">{{ $ville->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-2" class="form-label">Poids Minimum</label>
                                        <input type="number" class="form-control" name="poids_min">
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-2" class="form-label">Poids Maximum</label>
                                        <input type="number" class="form-control" name="poids_max">
                                    </div>

                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="modal-form-2" class="form-label">Tarif</label>
                                        <input type="number" class="form-control" name="tarif">
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
                    Affiche de 1 a 10 sur {{ $tarifs->count() }} plages de poids
                </div>

                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <form id="search-tarif" action="{{ route('adminSearchTarif') }}" method="GET" class="d-none">
                            @csrf
                            <input type="text" name="q" class="form-control w-56 box pr-10"
                                placeholder="Recherche...">
                            <a href=""
                                onclick="event.preventDefault(); document.getElementById('search-tarif').submit();">
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
                            <th class="whitespace-nowrap text-center">CODE</th>
                            <th class="text-center whitespace-nowrap">ORIGINE</th>
                            <th class="text-center whitespace-nowrap">DESTINATION</th>
                            <th class="text-center whitespace-nowrap">POIDS</th>
                            <th class="text-center whitespace-nowrap">TARIF</th>
                            <th class="text-center whitespace-nowrap">STATUT</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($tarifs)
                            @foreach ($tarifs as $tarif)
                                <tr class="intro-x">
                                    <td class="text-center">
                                        {{ $tarif->code }}
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">
                                            {{ $tarif->pays_exp }}
                                        </a>
                                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                            {{ $tarif->province_exp }}, {{ $tarif->ville_exp }}
                                        </div>
                                        {{ $tarif->libelle }}
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">
                                            {{ $tarif->pays_dest }}
                                        </a>
                                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                            {{ $tarif->province_dest }}, {{ $tarif->ville_dest }}
                                        </div>
                                        {{ $tarif->libelle }}
                                    </td>
                                    <td class="text-center">
                                        [ {{ $tarif->poids_min }} - {{ $tarif->poids_max }} ]
                                    </td>
                                    <td class="text-center">
                                        {{ $tarif->tarif }}
                                    </td>
                                    <td class="w-40">
                                        @if ($tarif->active == 1)
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
                                                data-tw-target="#update-{{ $tarif->id }}"> <i data-lucide="edit"
                                                    class="w-4 h-4 mr-1"></i> </a>
                                        </div>
                                    </td>
                                </tr>


                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="update-{{ $tarif->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('adminEditTarif') }}">
                                                @csrf
                                                <!-- BEGIN: Modal Header -->
                                                <div class="modal-header">
                                                    <h2 class="font-medium text-base mr-auto">Formulaire de Modification
                                                    </h2>
                                                </div> <!-- END: Modal Header -->
                                                <!-- BEGIN: Modal Body -->
                                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                                    <div class="col-span-12 sm:col-span-12">
                                                        <input type="hidden" name="forfait_id"
                                                            value="{{ $tarif->id }}">
                                                        <label for="modal-form-1" class="form-label">Code</label>
                                                        <input type="text" class="form-control" placeholder="P05"
                                                            name="code" value="{{ $tarif->code }}">
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-4">
                                                        <label for="modal-form-6" class="form-label">Pays Origine</label>
                                                        <select id="modal-form-6" class="form-select" name="pays_exp">
                                                            @foreach ($countries as $country)
                                                                @if ($country->libelle == $tarif->pays_exp)
                                                                    <option value="{{ $country->libelle }}" selected>
                                                                        {{ $country->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $country->libelle }}">
                                                                        {{ $country->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-4">
                                                        <label for="modal-form-6" class="form-label">Province
                                                            Origine</label>
                                                        <select id="modal-form-6" class="form-select"
                                                            name="province_exp">
                                                            @foreach ($provinces as $province)
                                                                @if ($province->libelle == $tarif->province_exp)
                                                                    <option value="{{ $province->libelle }}" selected>
                                                                        {{ $province->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $province->libelle }}">
                                                                        {{ $province->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-4">
                                                        <label for="modal-form-6" class="form-label">Ville Origine</label>
                                                        <select id="modal-form-6" class="form-select" name="ville_exp">
                                                            @foreach ($villes as $ville)
                                                                @if ($ville->id == $tarif->ville_exp)
                                                                    <option value="{{ $ville->libelle }}" selected>
                                                                        {{ $ville->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $ville->libelle }}">
                                                                        {{ $ville->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                    <div class="col-span-12 sm:col-span-4">
                                                        <label for="modal-form-6" class="form-label">Pays
                                                            Destination</label>
                                                        <select id="modal-form-6" class="form-select" name="pays_dest">
                                                            @foreach ($countries as $country)
                                                                @if ($country->libelle == $tarif->pays_dest)
                                                                    <option value="{{ $country->libelle }}" selected>
                                                                        {{ $country->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $country->libelle }}">
                                                                        {{ $country->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-4">
                                                        <label for="modal-form-6" class="form-label">Province
                                                            Destination</label>
                                                        <select id="modal-form-6" class="form-select"
                                                            name="province_dest">
                                                            @foreach ($provinces as $province)
                                                                @if ($province->libelle == $tarif->province_dest)
                                                                    <option value="{{ $province->libelle }}" selected>
                                                                        {{ $province->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $province->libelle }}">
                                                                        {{ $province->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-4">
                                                        <label for="modal-form-6" class="form-label">Ville
                                                            Destination</label>
                                                        <select id="modal-form-6" class="form-select" name="ville_dest">
                                                            @foreach ($villes as $ville)
                                                                @if ($ville->id == $tarif->ville_dest)
                                                                    <option value="{{ $ville->libelle }}" selected>
                                                                        {{ $ville->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $ville->libelle }}">
                                                                        {{ $ville->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-2" class="form-label">Poids Minimum</label>
                                                        <input type="number" class="form-control" name="poids_min"
                                                            value="{{ $tarif->poids_min }}">
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-2" class="form-label">Poids Maximum</label>
                                                        <input type="number" class="form-control" name="poids_max"
                                                            value="{{ $tarif->poids_max }}">
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-12">
                                                        <label for="modal-form-2" class="form-label">Tarif</label>
                                                        <input type="number" class="form-control" name="tarif"
                                                            value="{{ $tarif->tarif }}">
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
                    {{ $tarifs->links() }}
                </nav>
            </div>
            <!-- END: Pagination -->
        </div>

    </div>




@endsection
