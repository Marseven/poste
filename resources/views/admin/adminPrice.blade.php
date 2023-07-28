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
                            <form method="POST" action="{{ route('adminAddPrice') }}" name="addprice">
                                @csrf
                                <!-- BEGIN: Modal Header -->
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Formulaire d'ajout</h2>
                                </div> <!-- END: Modal Header -->
                                <!-- BEGIN: Modal Body -->
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                    <div class="col-span-12 sm:col-span-4 form-check mt-5">
                                        <input id="fees_sup" name="fees_sup" onChange="afficherFeesLabel()"
                                            class="form-check-input" type="checkbox" value="0">
                                        <label class="form-check-label" for="vertical-form-3">Frais supplémentaires</label>
                                    </div>

                                    <div id="label_fees" class="col-span-12 sm:col-span-4" style="display: none">
                                        <label for="modal-form-2" class="form-label">Libelle de Frais</label>
                                        <input type="text" class="form-control" name="label_fees">
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-6" class="form-label">Service</label>
                                        <select id="service" class="form-select" onChange="afficherPP()" name="service_id"
                                            required>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-6" class="form-label">Zone</label>
                                        <select id="modal-form-6" class="form-select" name="zone_id" required>
                                            @foreach ($zones as $zone)
                                                <option value="{{ $zone->id }}">{{ $zone->code . '.' . $zone->libelle }}
                                                </option>
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
                                        <select id="mode" class="form-select" onChange="afficherFirst()" name="mode_id"
                                            required>
                                            @foreach ($modes as $mode)
                                                <option value="{{ $mode->id }}">{{ $mode->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="weight" class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-2" class="form-label">Poids (KG)</label>
                                        <input type="number" step="0.01" class="form-control" name="weight">
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
                                        <label for="modal-form-2" class="form-label" id="label_price">Prix (FCFA)</label>
                                        <input type="number" class="form-control" name="price" required>
                                        <input type="hidden" id="type_element" name="type_element" value="null">
                                    </div>

                                    <div id="first" class="col-span-12 sm:col-span-4" style="display: none">
                                        <label for="modal-form-6" class="form-label">1er Kilo</label>
                                        <select id="modal-form-6" class="form-select" name="first" required>
                                            <option value="0">Non</option>
                                            <option value="1">Oui</option>
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-4">
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
                            <th class="text-center whitespace-nowrap">SERVICE</th>
                            <th class="text-center whitespace-nowrap">ZONE</th>
                            <th class="text-center whitespace-nowrap">MODE</th>
                            <th class="text-center whitespace-nowrap">PRIX</th>
                            <th class="text-center whitespace-nowrap">TYPE</th>
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
                                        {{ $price->service->libelle }}
                                    </td>
                                    <td class="text-center">
                                        {{ $price->zone->libelle }}
                                    </td>
                                    <td class="text-center">
                                        {{ $price->mode->libelle }}
                                    </td>
                                    <td class="text-center">
                                        {{ $price->price }} FCFA
                                    </td>
                                    <td class="text-center">
                                        {{ $price->type_element != null ? 'Par ' . $price->type_element : $price->weight . ' KG' }}
                                    </td>
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3" href="javascript:;"> <i data-lucide="trash"
                                                    class="w-4 h-4 mr-1"></i> </a>
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
                    {{ $prices->links() }}
                </nav>
            </div>
            <!-- END: Pagination -->
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function afficherFeesLabel() {
            var bp = document.getElementById("label_fees");
            var fees_sup = $('#fees_sup').val();

            if (fees_sup == "0") {
                bp.style.display = "block";
                $('#fees_sup').val("1");
            } else {
                bp.style.display = "none";
                $('#fees_sup').val("0");
            }
        }

        function afficherFirst() {
            var first = document.getElementById("first");
            var service = $('#service').val();
            var mode = $('#mode').val();

            if (service == 1 && mode == 2) {
                first.style.display = "block";
            } else {
                first.style.display = "none";
            }
        }

        function afficherPP() {
            // Sélectionner l'élément par son ID
            var monElement = document.getElementById("weight");
            var pricelabel = document.getElementById("label_price");
            var first = document.getElementById("first");
            var service = $('#service').val();
            var mode = $('#mode').val();

            // Ajouter un attribut "data-custom" avec la valeur "valeur_personnalisee"
            if (service == 1) {
                monElement.style.display = "block";
                $("#label_price").html("Prix (FCFA)");
                if (mode == 2) {
                    first.style.display = "block";
                }
                $('#type_element').val("null");
            }

            if (service == 2) {
                monElement.style.display = "block";
                $("#label_price").html("Prix (FCFA)");
                $('#type_element').val("null");
            }

            if (service == 3) {
                monElement.style.display = "none";
                $("#label_price").html("Prix par exemplaire (FCFA)");
                $('#type_element').val("Exemplaire");
            }

            if (service == 4) {
                monElement.style.display = "none";
                $("#label_price").html("Prix par KG (FCFA)");
                $('#type_element').val("KG");
            }

            if (service == 5) {
                monElement.style.display = "none";
                $("#label_price").html("Prix (FCFA)");
                $('#type_element').val("Exempt");
            }

            if (service == 6) {
                monElement.style.display = "block";
                $("#label_price").html("Prix (FCFA)");
                $('#type_element').val("null");
            }

            if (service == 7) {
                monElement.style.display = "block";
                $("#label_price").html("Prix (FCFA)");
                $('#type_element').val("null");
            }
        }
    </script>
@endpush
