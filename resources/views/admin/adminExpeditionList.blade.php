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
                                            href="{{ route('adminSuiviExpedition', ['code' => $expedition->code]) }}">
                                            {{ $expedition->code }}
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
                                                                <a href="javascript:;" data-tw-toggle="modal"
                                                                    data-tw-target="#pay-expedition-{{ $expedition->id }}"
                                                                    class="dropdown-item">Ajouter un
                                                                    paiement</a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a href="{{ route('adminFactureExpedition', ['code' => $expedition->code]) }}"
                                                                class="dropdown-item">Facture</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('adminEtiquetteExpedition', ['code' => $expedition->code]) }}"
                                                                class="dropdown-item">Etiquette</a>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- BEGIN: Modal Content -->
                                <div id="pay-expedition-{{ $expedition->id }}" class="modal">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <form id="pay-form-{{ $expedition->id }}"
                                                name="pay_form_{{ $expedition->id }}" method="POST"
                                                action="{{ route('adminFacturePay', ['code' => $expedition->code]) }}">
                                                @csrf
                                                <!-- BEGIN: Modal Header -->
                                                <div class="modal-header">
                                                    <h2 class="font-medium text-base mr-auto">Paiement de l'expedition N°
                                                        {{ $expedition->code }}
                                                    </h2>
                                                    <a data-tw-dismiss="modal" href="javascript:;"> <svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            icon-name="x" data-lucide="x"
                                                            class="lucide lucide-x w-8 h-8 text-slate-400">
                                                            <line x1="18" y1="6" x2="6"
                                                                y2="18"></line>
                                                            <line x1="6" y1="6" x2="18"
                                                                y2="18"></line>
                                                        </svg> </a>
                                                </div> <!-- END: Modal Header -->
                                                <div id="flash-message" style="padding: 7px;">

                                                </div>
                                                <!-- BEGIN: Modal Body -->
                                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                                    <div class="col-span-12 sm:col-span-12">
                                                        <label for="modal-form-1" class="form-label">Moyen de
                                                            Paiement</label>
                                                        <select class="form-control" id="methode"
                                                            onChange="afficherEbForm()" name="methode" required>
                                                            @foreach ($methodes as $methode)
                                                                <option value="{{ $methode->code }}">
                                                                    {{ $methode->libelle }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div id="eb" class="col-span-12 sm:col-span-12"
                                                        style="display:none">
                                                        <div class="col-span-12 sm:col-span-6">
                                                            <label for="modal-form-1" class="form-label">Opérateur
                                                            </label>
                                                            <select class="form-control" name="type" id="operator">
                                                                <option value="airtelmoney">Airtel Money</option>
                                                                <option value="moovmoney4">Moov Money</option>
                                                            </select>
                                                        </div>
                                                        <br>
                                                        <div class="col-span-12 sm:col-span-6">
                                                            <label for="modal-form-1" class="form-label">Numéro de
                                                                Téléphone*</label>
                                                            <input type="tel" class="form-control" id="phone"
                                                                placeholder="Ex. 077010203" name="phone">
                                                        </div>
                                                    </div>
                                                </div> <!-- END: Modal Body -->
                                                <!-- BEGIN: Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" data-id="{{ $expedition->id }}"
                                                        class="btn btn-primary shadow-md mr-2 valider">Valider</button>
                                                </div>
                                                <!-- END: Modal Footer -->
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- END: Modal Content -->
                                <!-- END: Large Modal Content -->
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

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function afficherEbForm() {
            var eb = document.getElementById("eb");
            if ($("#methode").val() != "EB") {
                eb.style.display = "none";
            } else {
                eb.style.display = "block";
            }
        }

        $(document).on("click", ".valider", function() {
            var id = $(this).data('id');
            var methode = document.pay_form_ + id.methode.value;
            var action = $("#pay-form-" + id).getAttribute("action");

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: action, // Chemin vers votre script PHP de traitement
                type: 'POST',
                data: {
                    id: id,
                    methode: methode,
                },
                success: function(result) {
                    console.log(result);
                    result = JSON.parse(result);

                }
            });
        });
    </script>
@endpush
