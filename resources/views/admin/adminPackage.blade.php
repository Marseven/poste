@extends('layouts.admin')

@section('page-content')

    <div class="col-span-12 2xl:col-span-12">
        <h2 class="intro-y text-lg font-medium mt-10">
            Packages
        </h2>
        <div class="grid grid-cols-12 gap-12 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#large-modal-size-preview"
                    class="btn btn-primary shadow-md mr-2">Nouveau Package</a>

                <!-- BEGIN: Large Modal Content -->
                <!-- BEGIN: Modal Content -->
                <div id="large-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('adminAddPackage') }}">
                                @csrf
                                <!-- BEGIN: Modal Header -->
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Formulaire d'ajout</h2>
                                </div> <!-- END: Modal Header -->
                                <!-- BEGIN: Modal Body -->
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-6" class="form-label">Ville Origine</label>
                                        <select id="modal-form-6" class="form-select" name="ville_origine_id">
                                            @foreach ($villes as $ville)
                                                <option value="{{ $ville->id }}">{{ $ville->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-6" class="form-label">Ville Destination</label>
                                        <select id="modal-form-6" class="form-select" name="ville_destination_id">
                                            @foreach ($villes as $ville)
                                                <option value="{{ $ville->id }}">{{ $ville->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-6" class="form-label">Agence Origine</label>
                                        <select id="modal-form-6" class="form-select" name="agence_origine_id">
                                            @foreach ($agences as $agence)
                                                <option value="{{ $agence->id }}">{{ $agence->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-6" class="form-label">Agence Destination</label>
                                        <select id="modal-form-6" class="form-select" name="agence_destination_id">
                                            @foreach ($agences as $agence)
                                                <option value="{{ $agence->id }}">{{ $agence->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="modal-form-2" class="form-label">Libelle</label>
                                        <input type="text" class="form-control" name="libelle">
                                    </div>

                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="modal-form-2" class="form-label">Description</label>
                                        <textarea class="form-control" name="description" rows="4"></textarea>
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
                    Affiche de 1 a 10 sur {{ $packages->count() }} packages
                </div>

                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <form id="search-packages" action="{{ route('adminSearchPackage') }}" method="GET"
                            class="d-none">
                            @csrf
                            <input type="text" name="q" class="form-control w-56 box pr-10"
                                placeholder="Recherche...">
                            <a href=""
                                onclick="event.preventDefault(); document.getElementById('search-packages').submit();">
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
                            <th class="whitespace-nowrap text-center">LIBELLE</th>
                            <th class="text-center whitespace-nowrap">POINT DE DEPART</th>
                            <th class="text-center whitespace-nowrap">DESTINATION</th>
                            <th class="text-center whitespace-nowrap">NBRE COLIS</th>
                            <th class="text-center whitespace-nowrap">STATUT</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($packages)
                            @foreach ($packages as $package)
                                <tr class="intro-x">
                                    <td class="text-center">
                                        <a href="{{ route('adminSuiviPackage', ['code' => $package->code]) }}"
                                            class="text-primary" target="_blank">
                                            {{ $package->code }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">
                                            {{ $package->libelle }}
                                        </a>
                                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                            {{ $package->description }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">
                                            {{ $package->agence_origine_id ? $package->agence_origine->libelle : 'Non defini' }}
                                        </a>
                                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                            {{ $package->ville_origine_id ? $package->ville_origine->libelle : 'Non defini' }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">
                                            {{ $package->agence_destination_id ? $package->agence_destination->libelle : 'Non defini' }}
                                        </a>
                                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                            {{ $package->ville_destination_id ? $package->ville_destination->libelle : 'Non defini' }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">
                                            {{ $package->nbre_colis }}
                                        </a>
                                    </td>
                                    <td class="w-40">
                                        @if ($package->active == 1)
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
                                                data-tw-target="#update-{{ $package->id }}"> <i data-lucide="edit"
                                                    class="w-4 h-4 mr-1"></i> </a>

                                            <a href="{{ route('adminDetailPackage', ['code' => $package->code]) }}"><i
                                                    data-lucide="eye" class="w-4 h-4 mr-1"></i></a>
                                        </div>
                                    </td>
                                </tr>


                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="update-{{ $package->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('adminEditPackage') }}">
                                                @csrf
                                                <!-- BEGIN: Modal Header -->
                                                <div class="modal-header">
                                                    <h2 class="font-medium text-base mr-auto">Formulaire de Modification
                                                    </h2>
                                                </div> <!-- END: Modal Header -->
                                                <!-- BEGIN: Modal Body -->
                                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                                    <input type="hidden" name="package_id" value="{{ $package->id }}">

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-6" class="form-label">Ville Origine</label>
                                                        <select id="modal-form-6" class="form-select"
                                                            name="ville_origine_id">
                                                            @foreach ($villes as $ville)
                                                                @if ($ville->id == $package->ville_origine_id)
                                                                    <option value="{{ $ville->id }}" selected>
                                                                        {{ $ville->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $ville->id }}">
                                                                        {{ $ville->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-6" class="form-label">Ville
                                                            Destination</label>
                                                        <select id="modal-form-6" class="form-select"
                                                            name="ville_destination_id">
                                                            @foreach ($villes as $ville)
                                                                @if ($ville->id == $package->ville_destination_id)
                                                                    <option value="{{ $ville->id }}" selected>
                                                                        {{ $ville->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $ville->id }}">
                                                                        {{ $ville->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-6" class="form-label">Agence
                                                            Origine</label>
                                                        <select id="modal-form-6" class="form-select"
                                                            name="agence_origine_id">
                                                            @foreach ($agences as $agence)
                                                                @if ($agence->id == $package->agence_origine_id)
                                                                    <option value="{{ $agence->id }}" selected>
                                                                        {{ $agence->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $agence->id }}">
                                                                        {{ $agence->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-6" class="form-label">Agence
                                                            Destination</label>
                                                        <select id="modal-form-6" class="form-select"
                                                            name="agence_destination_id">
                                                            @foreach ($agences as $agence)
                                                                @if ($agence->id == $package->agence_destination_id)
                                                                    <option value="{{ $agence->id }}" selected>
                                                                        {{ $agence->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $agence->id }}">
                                                                        {{ $agence->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-12">
                                                        <label for="modal-form-2" class="form-label">Libelle</label>
                                                        <input type="text" class="form-control" name="libelle"
                                                            value="{{ $package->libelle }}">
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-12">
                                                        <label for="modal-form-2" class="form-label">Description</label>
                                                        <textarea class="form-control" name="description" rows="4">{{ $package->libelle }}</textarea>
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
                    {{ $packages->links() }}
                </nav>
            </div>
            <!-- END: Pagination -->
        </div>

    </div>




@endsection
