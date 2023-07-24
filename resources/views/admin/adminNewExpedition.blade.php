@extends('layouts.admin')

@section('page-content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Nouvelle Expedition
        </h2>
    </div>
    <form id="global-form" name="form_exp" method="POST" action="{{ route('adminAddExpedition') }}">
        @csrf

        <div class="grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Profile Menu -->
            <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">
                <div class="intro-y box p-5 bg-warning text-black mt-5">
                    <div class="flex items-center">
                        <div class="font-medium text-lg">Etapes a suivre par l'operateur de saisi ou l'agent</div>
                    </div>
                    <div class="mt-4">
                        1. Choix de l'agence <br>
                        2. Expediteur & Destinataire <br>
                        3. Informations sur la livraison <br>
                        4. Ajout des pieces jointes <br>
                        5. Informations sur le(s) colis ou paquet(s) <br>
                    </div>

                </div>

                <div class="intro-y box p-5 bg-warning text-black mt-5">
                    <div class="flex items-center">
                        <div class="font-medium text-lg">Important</div>
                    </div>
                    <div class="mt-4">Les expeditions passees en agence beneficient d'une reduction de 2 % sur le montant
                        a payer.</div>

                </div>
            </div>

            <!-- END: Profile Menu -->
            <div class="col-span-12 lg:col-span-8 2xl:col-span-9">

                <div class="grid grid-cols-12 gap-6">

                    <!-- BEGIN: Daily Sales -->
                    <div class="intro-y box col-span-12 2xl:col-span-12">
                        <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-6">
                                <label for="modal-form-1" class="form-label">Prefixe d'expedition</label>
                                <input type="text" readonly class="form-control" name="code_aleatoire"
                                    value="{{ $code_aleatoire }}">
                            </div>
                            <div class="col-span-12 sm:col-span-6"></div>
                            <div class="col-span-12 sm:col-span-6">
                                <label for="modal-form-1" class="form-label">Réseau Destinataire</label>
                                <select class="form-control linked-select" target="zone" id="reseau" name="reseau_id"
                                    required>
                                    @foreach ($reseaux as $reseau)
                                        <option value="{{ $reseau->id }}">{{ $reseau->code }}, {{ $reseau->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <label for="modal-form-1" class="form-label">Zone destinataire</label>
                                <select class="form-control linked-select" target="pays" id="zone" name="zone_id"
                                    data-placeholder="Choisir une zone" required>

                                </select>
                            </div>

                            <div class="col-span-12 sm:col-span-6">
                                <label for="modal-form-1" class="form-label">Pays destinataire</label>
                                <select class="form-control linked-select" target="province" id="pays" name="pays_id"
                                    data-placeholder="Choisir un pays" required>
                                </select>
                            </div>

                            <div class="col-span-12 sm:col-span-6">
                                <label for="modal-form-1" class="form-label">Province destinataire</label>
                                <select class="form-control linked-select" target="ville" id="province" name="province_id"
                                    data-placeholder="Choisir une provine" required>
                                </select>
                            </div>

                            <div class="col-span-12 sm:col-span-6">
                                <label for="modal-form-1" class="form-label">Ville destinataire</label>
                                <select class="form-control linked-select" target="agence" id="ville" name="ville_id"
                                    data-placeholder="Choisir une ville" required>
                                </select>
                            </div>

                            <div class="col-span-12 sm:col-span-6">
                                <label for="modal-form-1" class="form-label">Bureau destinataire</label>
                                <select class="form-control linked-select" id="agence" name="agence_id"
                                    data-placeholder="Choisir un bureau de poste" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- END: Daily Sales -->

                    <!-- BEGIN: Daily Sales -->
                    <div class="intro-y box col-span-12 2xl:col-span-6">
                        <div
                            class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Expediteur
                            </h2>
                        </div>
                        <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-1" class="form-label">Nom complet*</label>
                                <input type="text" class="form-control" placeholder="Ex. Paul NDONG" name="name_exp"
                                    required>
                            </div>
                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-1" class="form-label">Email</label>
                                <input type="text" class="form-control" placeholder="Ex. paul.ndong@gmail.com"
                                    name="email_exp">
                            </div>
                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-1" class="form-label">Telephone*</label>
                                <input type="text" class="form-control" placeholder="Ex. +241 74 00 00 01"
                                    name="phone_exp" required>
                            </div>
                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-1" class="form-label">Adresse*</label>
                                <input type="text" class="form-control" placeholder="Ex. Face CKDO Oloumi"
                                    name="adresse_exp" required>
                            </div>
                        </div>
                    </div>
                    <!-- END: Daily Sales -->

                    <!-- BEGIN: Daily Sales -->
                    <div class="intro-y box col-span-12 2xl:col-span-6">
                        <div
                            class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Destinataire
                            </h2>
                        </div>
                        <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-1" class="form-label">Nom complet*</label>
                                <input type="text" class="form-control" placeholder="Ex. Arnaud MEZUI"
                                    name="name_dest" required>
                            </div>
                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-1" class="form-label">Email</label>
                                <input type="text" class="form-control" placeholder="Ex. mezui.a@gmail.com"
                                    name="email_dest">
                            </div>
                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-1" class="form-label">Telephone*</label>
                                <input type="text" class="form-control" placeholder="Ex. +241 66 00 00 02"
                                    name="phone_dest" required>
                            </div>
                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-1" class="form-label">Adresse*</label>
                                <input type="text" class="form-control" placeholder="Ex. Rond point democratie"
                                    name="adresse_dest" required>
                                <small>NB : <strong>Cette adresse est celle ou sera livre le colis !</strong></small>
                            </div>
                        </div>
                    </div>
                    <!-- END: Daily Sales -->

                    <!-- BEGIN: Daily Sales -->
                    <div class="intro-y box col-span-12 2xl:col-span-12">
                        <div
                            class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Informations sur la livraison
                            </h2>

                            {{-- <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#large-modal-size-preview"
                                class="btn btn-outline-secondary hidden sm:flex"> <i data-lucide="file"
                                    class="w-4 h-4 mr-2"></i> Pieces jointes </a> --}}
                        </div>
                        <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">

                            <div class="col-span-12 sm:col-span-6">
                                <label for="modal-form-1" class="form-label">Mode d'expédition</label>
                                <select class="form-control" name="mode_exp_id" id="mode" required>
                                    @foreach ($modes as $mode)
                                        <option value="{{ $mode->id }}">{{ $mode->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-12 sm:col-span-6">
                                <label for="modal-form-1" class="form-label">Livraison à domicile</label>
                                <select class="form-control" name="address" onChange="afficherBp()" required>
                                    <option value="1">Oui</option>
                                    <option value="0" selected>Non</option>
                                </select>
                            </div>

                            <div id="bp" class="col-span-12 sm:col-span-6" style="display: none;">
                                <label for="modal-form-1" class="form-label">Boîte Postal</label>
                                <input type="text" class="form-control" placeholder="BP. 12345" name="bp">
                            </div>

                            <br><br>

                            {{-- @if (!empty($documents))
                                @foreach ($documents as $document)
                                    <div class="intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
                                        <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
                                            <div class="absolute left-0 top-0 mt-3 ml-3">
                                                <input class="form-check-input border border-slate-500" type="checkbox">
                                            </div>
                                            <a href=""
                                                class="w-3/5 file__icon file__icon--empty-directory mx-auto"></a> <a
                                                href=""
                                                class="block font-medium mt-4 text-center truncate">{{ $document->libelle }}</a>
                                            <div class="text-slate-500 text-xs text-center mt-0.5">{{ $document->code }}
                                            </div>
                                            <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
                                                <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                                                    aria-expanded="false" data-tw-toggle="dropdown"> <i
                                                        data-lucide="more-vertical" class="w-5 h-5 text-slate-500"></i>
                                                </a>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item"> <i
                                                                    data-lucide="trash" class="w-4 h-4 mr-2"></i>
                                                                Supprimer </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            @endif --}}

                        </div>
                    </div>
                    <!-- END: Daily Sales -->

                    <!-- BEGIN: Daily Sales -->
                    <div class="intro-y box col-span-12 2xl:col-span-12">
                        <div
                            class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Informations sur le(s) élément(s)
                            </h2>

                            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#colis-preview"
                                class="btn btn-outline-secondary hidden sm:flex"> <i data-lucide="file"
                                    class="w-4 h-4 mr-2"></i> Ajouter un autre élément </a>
                        </div>
                        <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                                <table class="table table-report -mt-2">
                                    <thead>
                                        <tr>
                                            <th class="whitespace-nowrap text-center">CODE</th>
                                            <th class="text-center whitespace-nowrap">SERVICE</th>
                                            <th class="text-center whitespace-nowrap">LIBELLE</th>
                                            <th class="text-center whitespace-nowrap">POIDS</th>
                                            <th class="text-center whitespace-nowrap">PRIX</th>
                                            <th class="text-center whitespace-nowrap">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody id="content-table">

                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th class="text-center whitespace-nowrap"></th>
                                            <th class="text-center whitespace-nowrap"></th>
                                            <th class="whitespace-nowrap text-center">TOTAL</th>
                                            <th id="total" class="text-center whitespace-nowrap">0 FCFA</th>
                                            <input type="hidden" value="0" id="amount" name="amount">
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <br><br>

                            {{-- @if (!empty($paquets))
                                @foreach ($paquets as $paquet)
                                    <div class="intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
                                        <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
                                            <div class="absolute left-0 top-0 mt-3 ml-3">
                                                <input class="form-check-input border border-slate-500" type="checkbox">
                                            </div>
                                            <a href=""
                                                class="w-3/5 file__icon file__icon--empty-directory mx-auto"></a> <a
                                                href=""
                                                class="block font-medium mt-4 text-center truncate">{{ $paquet->libelle }}</a>
                                            <div class="text-slate-500 text-xs text-center mt-0.5">{{ $paquet->code }}
                                            </div>
                                            <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
                                                <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                                                    aria-expanded="false" data-tw-toggle="dropdown"> <i
                                                        data-lucide="more-vertical" class="w-5 h-5 text-slate-500"></i>
                                                </a>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item"> <i
                                                                    data-lucide="trash" class="w-4 h-4 mr-2"></i>
                                                                Supprimer </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            @endif --}}

                        </div>
                    </div>
                    <!-- END: Daily Sales -->

                    <!-- BEGIN: Daily Sales -->
                    <div class="ml-auto flex items-center">
                        <button type="submit" class="btn btn-primary shadow-md mr-2">Soumttre</button>
                        <button type="reset" class="btn btn-danger shadow-md mr-2">Annueler</button>
                    </div>
                    <!-- END: Daily Sales -->



                </div>
            </div>

        </div>
    </form>

    {{-- <!-- BEGIN: Modal Content -->
        <div id="large-modal-size-preview" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="document-form" method="POST" action="{{ route('adminNewDocument') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- BEGIN: Modal Header -->
                        <div class="modal-header">
                            <h2 class="font-medium text-base mr-auto">Formulaire d'ajout d'une piece jointe</h2>
                        </div> <!-- END: Modal Header -->
                        <!-- BEGIN: Modal Body -->
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-6">
                                <label for="modal-form-1" class="form-label">Code</label>
                                <input type="text" class="form-control" readonly name="code"
                                    value="{{ $code_aleatoire }}">
                            </div>

                            <div class="col-span-12 sm:col-span-6">
                                <label for="modal-form-2" class="form-label">Nom de la piece</label>
                                <input type="text" class="form-control" placeholder="Manifeste" name="libelle">
                            </div>

                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-2" class="form-label">Piece jointe</label>
                                <input type="file" class="form-control" name="image">
                            </div>



                        </div> <!-- END: Modal Body -->
                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer">
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('document-form').submit();"
                                class="btn btn-primary shadow-md mr-2">Soumettre</a>
                        </div>
                        <!-- END: Modal Footer -->
                    </form>
                </div>
            </div>
        </div> <!-- END: Modal Content -->
        <!-- END: Large Modal Content --> --}}


    <!-- BEGIN: Modal Content -->
    <div id="colis-preview" class="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form id="paquet-form" name="paquet_form" method="POST" action="{{ route('adminNewPaquet') }}">
                    @csrf
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Formulaire d'ajout d'un colis</h2>
                        <a data-tw-dismiss="modal" href="javascript:;"> <svg xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x"
                                data-lucide="x" class="lucide lucide-x w-8 h-8 text-slate-400">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg> </a>
                    </div> <!-- END: Modal Header -->
                    <div id="flash-message" style="padding: 7px;">

                    </div>
                    <!-- BEGIN: Modal Body -->
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-1" class="form-label">Code*</label>
                            <input type="text" class="form-control" id="code" name="code" readonly
                                value="{{ $code_aleatoire }}">
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-1" class="form-label">Service d'expédition</label>
                            <select class="form-control" id="service" onChange="maxWeight()" name="service_exp_id"
                                required>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->libelle }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-1" class="form-label">Type d'élément*</label>
                            <select class="form-control" name="type" id="type">
                                <option value="0">Choisir</option>
                                <option>Fragile</option>
                                <option>Cassable</option>
                            </select>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-1" class="form-label">Libelle*</label>
                            <input type="text" class="form-control" id="libelle" placeholder="Ex. Courrier"
                                name="libelle" required>
                        </div>

                        <div class="col-span-12 sm:col-span-6">

                            <label for="modal-form-1" class="form-label">Poids*</label>
                            <input type="number" step="0.01" id="poids" class="form-control" max="2"
                                name="weight" required>
                        </div>

                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1" class="form-label">Description*</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>



                    </div> <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary shadow-md mr-2">Soumettre</button>
                    </div>
                    <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div> <!-- END: Modal Content -->
    <!-- END: Large Modal Content -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function afficherBp() {
            var bp = document.getElementById("bp");

            if (document.form_exp.address.value != "1") {
                bp.style.display = "none";
            } else {
                bp.style.display = "block";
            }
        }

        function maxWeight() {
            // Sélectionner l'élément par son ID
            var monElement = document.getElementById("poids");
            var service = $('#service').val();

            // Ajouter un attribut "data-custom" avec la valeur "valeur_personnalisee"
            if (service == 1) {
                monElement.setAttribute("max", "2");
            }

            if (service == 2) {
                monElement.setAttribute("max", "5");
            }

            if (service == 3) {
                monElement.setAttribute("max", "20");
            }
        }

        $(".linked-select").change(function() {
            var id = $(this).val();
            var target = $(this).attr('target');
            $.ajax({
                url: "{{ route('adminSelect') }}",
                data: {
                    'id': id,
                    'target': target,
                },
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                    result = JSON.parse(result);
                    var option_html = "<option value='0'>Choisir</option>";

                    for (i = 0; i < result.length; i++) {
                        is_selected = $("#" + target).data('val') == result[i].id ? 'selected' : '';
                        option_html += "<option " + is_selected + "  value='" + result[i].id +
                            "'>" +
                            result[i].libelle +
                            "</option>";
                    }

                    $("#" + target).html(option_html);
                    $("#" + target).change();
                }
            });
        });

        $(".linked-select").change();


        $('#paquet-form').submit(function(e) {
            e.preventDefault();

            var code = $('#code').val();
            var libelle = $('#libelle').val();
            var poids = $('#poids').val();
            var description = $('#description').val();
            var type = $('#type').val();
            var mode = $('#mode').val();

            var zone = $('#zone').val();
            var service = $('#service').val();

            var amount = parseFloat($('#amount').val());

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('adminNewPaquet') }}", // Chemin vers votre script PHP de traitement
                type: 'POST',
                data: {
                    code: code,
                    libelle: libelle,
                    poids: poids,
                    zone: zone,
                    service: service,
                    mode: mode,
                    type: type,
                    description: description
                },
                success: function(result) {
                    console.log(result);
                    result = JSON.parse(result);
                    if (result == 0) {
                        var flash =
                            "<div class='alert alert-danger show mb-2' role='alert'>Il faut choisir une Zone !</div>"
                        $('#flash-message').append(flash);
                    }

                    if (result == 1) {
                        var flash =
                            "<div class='alert alert-danger show mb-2' role='alert'>Il faut choisir un service !</div>"
                        $('#flash-message').append(flash);
                    }

                    if (result != 0 || result != 1) {
                        var option_html =
                            "<tr id='colis-" + result.id +
                            "' class='intro-x'><td class='text-center'>" +
                            result.code +
                            "</td><td class='text-center'>" +
                            result.service.libelle +
                            "</td><td class='text-center'>" + result.libelle +
                            "</td><td class='text-center'>" + result.poids +
                            " KG(s)</td><td class='text-center'>" + result.amount +
                            " FCFA</td><td class='text-center'><button id='delete-colis' type='button' target='" +
                            result.id +
                            "' onclick='removeElement()' class='btn btn-danger'>Supprimer</button></td> </tr>";

                        var flash =
                            "<div class='alert alert-success show mb-2' role='alert'>Colis ajouté !</div>"

                        amount += parseFloat(result.amount);
                        var amount_html = "<strong>" + amount + " FCFA</strong>"
                        $("#amount").val(amount);
                        $('#content-table').append(option_html);
                        $('#total').html(amount_html);
                        $('#paquet-form').trigger("reset");
                        const myModal = tailwind.Modal.getOrCreateInstance(document.querySelector(
                            "#colis-preview"));
                        myModal.hide();
                    }

                }
            });
        });


        function removeElement() {

            var id = $("#delete-colis").attr('target');
            var amount = parseFloat($('#amount').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('adminDeletePaquet') }}", // Chemin vers votre script PHP de traitement
                type: 'POST',
                data: {
                    id: id,
                },
                success: function(result) {
                    console.log(result);
                    result = JSON.parse(result);
                    if (result != 0) {
                        $('#colis-' + result[0]).remove();
                        amount -= parseFloat(result[1]);
                        if (amount < 0) amount = 0;
                        var amount_html = "<strong>" + amount + " FCFA</strong>"
                        $("#amount").val(amount);
                        $('#total').html(amount_html);
                    } else {
                        alert('Le colis ne peux être supprimé.')
                    }

                }
            });

        }
    </script>
@endpush
