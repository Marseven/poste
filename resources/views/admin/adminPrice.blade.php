@extends('layouts.admin')

@section('page-content')

    <div class="col-span-12 2xl:col-span-12">
        <h2 class="intro-y text-lg font-medium mt-10">
            Tarifs d'expedition
        </h2>
        <div class="grid grid-cols-12 gap-12 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#large-modal-size-preview"
                    class="btn btn-primary shadow-md mr-2">Nouveau tarif</a>

                <!-- BEGIN: Large Modal Content -->
                <!-- BEGIN: Modal Content -->
                <div id="large-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('adminAddPrice') }}">
                                @csrf
                                <!-- BEGIN: Modal Header -->
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Formulaire d'ajout</h2>
                                </div> <!-- END: Modal Header -->
                                <!-- BEGIN: Modal Body -->
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="modal-form-1" class="form-label">Code</label>
                                        <input type="text" class="form-control" placeholder="R000001" name="code"
                                            required>
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-6" class="form-label">Service</label>
                                        <select id="modal-form-6" class="form-select" name="service_id" required>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-6" class="form-label">Zone</label>
                                        <select id="modal-form-6" class="form-select" name="zone_id" required>
                                            @foreach ($zones as $zone)
                                                <option value="{{ $zone->id }}">{{ $zone->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-6" class="form-label">Type</label>
                                        <select id="modal-form-6" class="form-select" name="type" required>
                                            <option>Standard</option>
                                            <option>Suppémentaire</option>
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-6" class="form-label">Mode</label>
                                        <select id="modal-form-6" class="form-select" name="mode_id" required>
                                            @foreach ($modes as $mode)
                                                <option value="{{ $mode->id }}">{{ $mode->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-2" class="form-label">Poids (KG)</label>
                                        <input type="number" step="0.01" class="form-control" name="weight" required>
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-2" class="form-label">Prix (FCFA)</label>
                                        <input type="number" class="form-control" name="price" required>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-6" class="form-label">1er Kilo</label>
                                        <select id="modal-form-6" class="form-select" name="first" required>
                                            <option value="0">Non</option>
                                            <option value="1">Oui</option>
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-6" class="form-label">Statut</label>
                                        <select id="modal-form-6" class="form-select" name="active" required>
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
                    Affiche de 1 a 10 sur {{ $prices->count() }} tarifs
                </div>

                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <form id="search-price" action="{{ route('adminSearchPrice') }}" method="GET" class="d-none">
                            @csrf
                            <input type="text" name="q" class="form-control w-56 box pr-10"
                                placeholder="Recherche...">
                            <a href=""
                                onclick="event.preventDefault(); document.getElementById('search-price').submit();">
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
                            <th class="whitespace-nowrap text-center">CODE</th>
                            <th class="text-center whitespace-nowrap">SERVICE</th>
                            <th class="text-center whitespace-nowrap">ZONE</th>
                            <th class="text-center whitespace-nowrap">TYPE</th>
                            <th class="text-center whitespace-nowrap">MODE</th>
                            <th class="text-center whitespace-nowrap">POIDS</th>
                            <th class="text-center whitespace-nowrap">PRIX</th>
                            <th class="text-center whitespace-nowrap">STATUT</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($prices)
                            @foreach ($prices as $price)
                                @php
                                    $price->load(['service', 'zone', 'mode']);
                                @endphp
                                <tr class="intro-x">
                                    <td class="text-center">
                                        {{ $price->code }}
                                    </td>
                                    <td class="text-center">
                                        {{ $price->service->libelle }}
                                    </td>
                                    <td class="text-center">
                                        {{ $price->zone->libelle }}
                                    </td>
                                    <td class="text-center">
                                        {{ $price->type }}
                                    </td>
                                    <td class="text-center">
                                        {{ $price->mode->libelle }}
                                    </td>
                                    <td class="text-center">
                                        {{ $price->weight }} KG
                                    </td>
                                    <td class="text-center">
                                        {{ $price->price }} FCFA
                                    </td>
                                    <td class="w-40">
                                        @if ($price->active == 1)
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
                                                data-tw-target="#update-{{ $price->id }}"> <i data-lucide="edit"
                                                    class="w-4 h-4 mr-1"></i> </a>
                                        </div>
                                    </td>
                                </tr>


                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="update-{{ $price->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('adminEditPrice') }}">
                                                @csrf
                                                <!-- BEGIN: Modal Header -->
                                                <div class="modal-header">
                                                    <h2 class="font-medium text-base mr-auto">Formulaire de Modification
                                                    </h2>
                                                </div> <!-- END: Modal Header -->
                                                <!-- BEGIN: Modal Body -->
                                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                                    <div class="col-span-12 sm:col-span-12">
                                                        <input type="hidden" name="price_id"
                                                            value="{{ $price->id }}">
                                                        <label for="modal-form-1" class="form-label">Code</label>
                                                        <input type="text" class="form-control" placeholder="P05"
                                                            name="code" value="{{ $price->code }}" required>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-4">
                                                        <label for="modal-form-6" class="form-label">Service</label>
                                                        <select id="modal-form-6" class="form-select" name="service_id"
                                                            required>
                                                            @foreach ($services as $service)
                                                                @if ($service->id == $price->service_id)
                                                                    <option value="{{ $service->id }}" selected>
                                                                        {{ $service->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $service->id }}">
                                                                        {{ $service->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-4">
                                                        <label for="modal-form-6" class="form-label">Zone</label>
                                                        <select id="modal-form-6" class="form-select" name="zone_id"
                                                            required>
                                                            @foreach ($zones as $zone)
                                                                @if ($zone->id == $price->zone_id)
                                                                    <option value="{{ $zone->id }}" selected>
                                                                        {{ $zone->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $zone->id }}">
                                                                        {{ $zone->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-4">
                                                        <label for="modal-form-6" class="form-label">Type</label>
                                                        <select id="modal-form-6" class="form-select" name="type"
                                                            required>
                                                            <option {{ $price->type == 'Standard' ? 'selected' : '' }}>
                                                                Standard</option>
                                                            <option
                                                                {{ $price->type == 'Suppémentaire' ? 'selected' : '' }}>
                                                                Suppémentaire</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-4">
                                                        <label for="modal-form-6" class="form-label">Mode</label>
                                                        <select id="modal-form-6" class="form-select" name="mode_id"
                                                            required>
                                                            @foreach ($modes as $mode)
                                                                @if ($mode->id == $price->mode_id)
                                                                    <option value="{{ $mode->id }}" selected>
                                                                        {{ $mode->libelle }}</option>
                                                                @else
                                                                    <option value="{{ $mode->id }}">
                                                                        {{ $mode->libelle }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-4">
                                                        <label for="modal-form-2" class="form-label">Poids (KG)</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $price->weight }}" name="weight" required>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-4">
                                                        <label for="modal-form-2" class="form-label">Prix (FCFA)</label>
                                                        <input type="number" class="form-control"
                                                            value="{{ $price->price }}" name="price" required>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-6" class="form-label">1er Kilo</label>
                                                        <select id="modal-form-6" class="form-select" name="first"
                                                            required>
                                                            <option {{ $price->first == 0 ? 'selected' : '' }}
                                                                value="0">Non</option>
                                                            <option {{ $price->first == 1 ? 'selected' : '' }}
                                                                value="1">Oui</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-6" class="form-label">Statut</label>
                                                        <select id="modal-form-6" class="form-select" name="active"
                                                            required>
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
                    {{ $prices->links() }}
                </nav>
            </div>
            <!-- END: Pagination -->
        </div>

    </div>




@endsection
