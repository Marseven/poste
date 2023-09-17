@extends('layouts.admin')

@section('page-content')

    <div class="col-span-12 2xl:col-span-12">
        <h2 class="intro-y text-lg font-medium mt-10">
            Expeditions Jour J
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
            <div class="intro-y col-span-12 overflow-auto">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap text-center">SUIVI</th>
                            <th class="text-center whitespace-nowrap">DATE</th>
                            <th class="text-center whitespace-nowrap">MODE</th>
                            <th class="text-center whitespace-nowrap">EXPEDITEUR</th>
                            <th class="text-center whitespace-nowrap">DESTINATAIRE</th>
                            <th class="text-center whitespace-nowrap">COUT TOTAL</th>
                            <th class="text-center whitespace-nowrap">STATUT FACTURE</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" id="id">
                        @if ($expeditions->count() > 0)
                            @foreach ($expeditions as $expedition)
                                <tr class="intro-x">
                                    <td class="text-center bg-primary">
                                        <a class="text-primary"
                                            href="{{ route('adminSuiviExpedition', ['code' => $expedition->code]) }}">
                                            {{ $expedition->code }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($expedition->created_at)->translatedFormat('d-m-Y') }}
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="text-md px-1 bg-{{ $expedition->mode_exp_id == 2 ? 'danger' : 'primary' }} text-white mr-1"
                                            style="padding:5px; font-weight: 600;">
                                            {{ $expedition->mode->libelle }}</span>
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
                                        {{ $expedition->amount ? number_format($expedition->amount, 0, ',', ' ') : 0 }} XAF
                                    </td>
                                    <td class="w-40">
                                        @if ($expedition->status == 3)
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Payée </div>
                                        @else
                                            <div class="flex items-center justify-center text-warning"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> En attente de
                                                paiement </div>
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
                                                        @if ($expedition->status != 3)
                                                            <li>
                                                                <a href="javascript:;" data-tw-toggle="modal"
                                                                    data-tw-target="#pay-expedition-{{ $expedition->id }}"
                                                                    class="dropdown-item"
                                                                    onclick="setId({{ $expedition->id }})">Ajouter un
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
                                                        <select class="form-control" id="methode-{{ $expedition->id }}"
                                                            onChange="afficherEbForm()" name="methode" required>
                                                            @foreach ($methodes as $methode)
                                                                <option value="{{ $methode->code }}">
                                                                    {{ $methode->libelle }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div id="eb-{{ $expedition->id }}" class="col-span-12 sm:col-span-12"
                                                        style="display:none">

                                                        <div class="mt-3"> <label>Choisissez une option</label>
                                                            <div class="flex flex-col sm:flex-row mt-2">
                                                                <div class="form-check mr-2"> <input
                                                                        class="form-check-input"
                                                                        id="paylink-direct-{{ $expedition->id }}"
                                                                        type="radio" name="paylink" value="direct"
                                                                        onChange="afficherLinkForm()" required>
                                                                    <label class="form-check-label"
                                                                        for="radio-switch-4">Paiement Direct</label>
                                                                </div>
                                                                <div class="form-check mr-2 mt-2 sm:mt-0"> <input
                                                                        class="form-check-input"
                                                                        id="paylink-link-{{ $expedition->id }}"
                                                                        type="radio" name="paylink" value="link"
                                                                        onChange="afficherLinkForm()" required>
                                                                    <label class="form-check-label"
                                                                        for="radio-switch-5">Lien de Paiement</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div id="direct-form-{{ $expedition->id }}"
                                                            style="display: none">
                                                            <div class="col-span-12 sm:col-span-6">
                                                                <label for="modal-form-1" class="form-label">Opérateur
                                                                </label>
                                                                <select class="form-control" name="operator"
                                                                    id="operator-{{ $expedition->id }}">
                                                                    <option value="airtelmoney">Airtel Money</option>
                                                                    <option value="moovmoney4">Moov Money</option>
                                                                </select>
                                                            </div>
                                                            <br>
                                                            <div class="col-span-12 sm:col-span-6">
                                                                <label for="modal-form-1" class="form-label">Numéro de
                                                                    Téléphone*</label>
                                                                <input type="tel" class="form-control"
                                                                    id="phone-{{ $expedition->id }}"
                                                                    placeholder="Ex. 077XXXXXX / 066XXXXXX "
                                                                    name="phone" maxlength="9"
                                                                    oninput="verifierEtAfficherErreur()">
                                                                <span id="messageErreur-{{ $expedition->id }}"
                                                                    style="color: red; display: none;"></span>
                                                            </div>
                                                        </div>

                                                        <div id="link-form-{{ $expedition->id }}" style="display: none">
                                                            <div class="col-span-12 sm:col-span-6">
                                                                <label for="modal-form-1"
                                                                    class="form-label">Email*</label>
                                                                <input type="email" class="form-control"
                                                                    id="email-{{ $expedition->id }}"
                                                                    placeholder="axy@test.com" name="email">
                                                            </div>
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
                        @endif
                    </tbody>
                </table>
                @if ($expeditions->count() == 0)
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
                    {{ $expeditions->links() }}
                </nav>
            </div>
            <!-- END: Pagination -->
        </div>
    </div>

    <!-- BEGIN: Modal Content -->
    <div id="success-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center"> <i data-lucide="check-circle"
                            class="w-16 h-16 text-success mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Expédition Payée !</div>
                        <div class="text-slate-500 mt-2"></div>
                    </div>
                    <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal"
                            class="btn btn-primary w-24" onclick="reloadPage()">Ok</button> </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Modal Content -->

    <!-- BEGIN: Modal Content -->
    <div id="error-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center"> <i data-lucide="cross" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Paiment non ajouté</div>
                        <div class="text-slate-500 mt-2"></div>
                    </div>
                    <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal"
                            class="btn btn-primary w-24">Ok</button> </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Modal Content -->

    <!-- BEGIN: Modal Content -->
    <div id="countdown" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-10 text-center">
                    <div class="col-span-6 sm:col-span-3 xl:col-span-2 flex flex-col justify-end items-center">
                        <svg width="200" viewBox="-2 -2 42 42" xmlns="http://www.w3.org/2000/svg"
                            stroke="rgb(250 204 21)" class="w-20 h-20">
                            <g fill="none" fill-rule="evenodd">
                                <g transform="translate(1 1)" stroke-width="4">
                                    <circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle>
                                    <path d="M36 18c0-9.94-8.06-18-18-18">
                                        <animateTransform attributeName="transform" type="rotate" from="0 18 18"
                                            to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform>
                                    </path>
                                </g>
                            </g>
                        </svg>
                        <br><br>
                        <div class="text-center text-md text-primary mt-2" id="countdown-text"
                            style="font-size: 3em; font-weight: 800;">30</div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- END: Modal Content -->

    <div id="link-response" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-10 text-center">
                    <div class="col-span-6 sm:col-span-3 xl:col-span-2 flex flex-col justify-end items-center">
                        <div class="text-center text-md text-primary mt-2" id="link-text"
                            style="font-size: 2em; font-weight: 800;"></div>
                        <br>
                        <div class="px-5 pb-8 text-center"><a href="#" id="link-share" data-tw-dismiss="modal"
                                class="btn btn-primary w-24">Partager le lien par mail</a> </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- END: Modal Content -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function afficherEbForm() {
            var id = $("#id").val();
            var eb = $("#eb-" + id);
            if ($("#methode-" + id).val() == "EB") {
                eb.show();
            } else {
                eb.hide();
            }
        }

        function afficherLinkForm() {
            var id = $("#id").val();
            const link = $("#link-form-" + id);
            const direct = $("#direct-form-" + id);
            var selectedValue = $("input[name='paylink']:checked").val();
            if (selectedValue == "direct") {
                direct.show();
                link.hide();
            } else {
                direct.hide();
                link.show();
            }
        }

        function setId(idexp) {
            $("#id").val(idexp);
        }

        function verifierNumeroAirtel(numero) {
            // Expression régulière pour vérifier le format airtel : 074, 077 ou 076 suivi de 6 chiffres
            const regexNumeroAirtel = /^(074|077|076)\d{6}$/;
            return regexNumeroAirtel.test(numero);
        }

        function verifierNumeroMoov(numero) {
            // Expression régulière pour vérifier le format moov : 065, 066 ou 062 suivi de 6 chiffres
            const regexNumeroMoov = /^(062|066|065)\d{6}$/;
            return regexNumeroMoov.test(numero);
        }

        function verifierEtAfficherErreur() {
            const id = $("#id").val();
            const inputNumero = document.getElementById('phone-' + id);
            const operator = document.getElementById('operator-' + id);
            const messageErreur = document.getElementById('messageErreur-' + id);
            const numero = inputNumero.value;

            if (operator.value == 'airtelmoney') {
                if (verifierNumeroAirtel(numero)) {
                    // Numéro valide
                    messageErreur.style.display = 'none';
                } else {
                    // Numéro invalide
                    messageErreur.style.display = 'inline'; // Affiche le message d'erreur
                    messageErreur.textContent =
                        'Le numéro de téléphone doit être au format Airtel (074xxxxxx, 077xxxxxx ou 076xxxxxx).';
                }
            } else {
                if (verifierNumeroMoov(numero)) {
                    // Numéro valide
                    messageErreur.style.display = 'none';
                } else {
                    // Numéro invalide
                    messageErreur.style.display = 'inline'; // Affiche le message d'erreur
                    messageErreur.textContent =
                        'Le numéro de téléphone doit être au format Moov (062xxxxxx, 066xxxxxx ou 065xxxxxx).';
                }
            }
        }

        $(document).on("click", ".valider", function() {

            $(".valider").prop('disabled', true);

            let timeLeft = 30; // Temps restant en secondes
            let bill_id = "0";
            let link = "#";
            const id = $(this).data('id');
            const countdownElement = $('#countdown-text');
            const linkElement = $('#link-text');
            const methode = $("#methode-" + id).val();

            const operator = $("#operator-" + id).val();
            const phone = $("#phone-" + id).val();
            const email = $("#email-" + id).val();
            const paylink = $("input[name='paylink']:checked").val();
            const action = $("#pay-form-" + id).attr('action');

            if (methode == "CA") {
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
                        if (result.success == true) {

                            const form = tailwind.Modal.getInstance(document.querySelector(
                                "#pay-expedition-" + id));
                            form.hide();

                            const success = tailwind.Modal.getInstance(document.querySelector(
                                "#success-modal"));
                            success.show();
                        } else {
                            const form = tailwind.Modal.getInstance(document.querySelector(
                                "#pay-expedition-" + id));
                            form.hide();

                            const error = tailwind.Modal.getInstance(document.querySelector(
                                "#error-modal"));
                            error.show();
                        }
                        $(".valider").prop('disabled', false);

                    },
                    error: function(xhr, status, error) {
                        // Une erreur s'est produite lors de la requête AJAX
                        console.log(
                            'Erreur lors de la requête AJAX : ' +
                            error);
                        // Continuez le compte à rebours même en cas d'erreur
                        $(".valider").prop('disabled', false);
                    },
                    complete: function() {
                        // Réactivez le bouton une fois que la requête AJAX est terminée
                        $(".valider").prop('disabled', false);
                    }
                });
            } else {

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: action, // Chemin vers votre script PHP de traitement
                    type: 'POST',
                    data: {
                        id: id,
                        paylink: paylink,
                        methode: methode,
                        operator: operator,
                        phone: phone,
                        email: email,
                    },
                    success: function(result) {
                        console.log(result);
                        if (result.success == true) {
                            if (paylink == "direct") {
                                bill_id = result.data.bill_id;

                                const count = tailwind.Modal.getInstance(document.querySelector(
                                    "#countdown"));
                                count.show();

                                const countdownInterval = setInterval(function() {
                                    if (timeLeft > 0) {
                                        // Affichez le nombre de secondes restantes
                                        console.log(`Temps restant : ${timeLeft} secondes`);
                                        countdownElement.text(timeLeft);
                                        timeLeft--;

                                    } else {
                                        // Le compte à rebours est terminé, mais le statut n'est toujours pas bon
                                        console.log(
                                            'Compte à rebours terminé, mais statut incorrect'
                                        );
                                        // Faites ce que vous devez faire lorsque le statut n'est pas bon à la fin du compte à rebours
                                        // Par exemple, affichez un message d'erreur ou effectuez une autre action

                                        // Arrêtez le compte à rebours
                                        clearInterval(countdownInterval);

                                        const count = tailwind.Modal.getInstance(document
                                            .querySelector(
                                                "#countdown"));

                                        count.hide();

                                        $(".valider").prop('disabled', false);
                                    }
                                }, 1000);

                                const checkInterval = setInterval(function() {
                                    if (timeLeft > 0) {
                                        // Affichez le nombre de secondes restantes
                                        console.log(`Temps restant : ${timeLeft} secondes`);

                                        // Effectuez la requête AJAX vers votre script PHP pour vérifier le statut
                                        $.ajax({
                                            url: "{{ route('checkBill') }}", // Chemin vers votre script PHP de traitement
                                            type: 'GET',
                                            data: {
                                                bill_id: bill_id,
                                            },
                                            dataType: 'json',
                                            success: function(result) {
                                                console.log(result);
                                                if (result.success == true) {

                                                    clearInterval(
                                                        countdownInterval);
                                                    clearInterval(checkInterval);

                                                    const count = tailwind.Modal
                                                        .getInstance(
                                                            document.querySelector(
                                                                "#countdown"));
                                                    count.hide();

                                                    const form = tailwind.Modal
                                                        .getInstance(document
                                                            .querySelector(
                                                                "#pay-expedition-" +
                                                                id)
                                                        );
                                                    form.hide();

                                                    const success = tailwind.Modal
                                                        .getInstance(
                                                            document.querySelector(
                                                                "#success-modal"));
                                                    success.show();
                                                }
                                                $(".valider").prop('disabled',
                                                    false);
                                            },
                                            error: function(xhr, status, error) {
                                                // Une erreur s'est produite lors de la requête AJAX
                                                console.log(
                                                    'Erreur lors de la requête AJAX : ' +
                                                    error);
                                                $(".valider").prop('disabled',
                                                    false);
                                                // Continuez le compte à rebours même en cas d'erreur
                                            },
                                            complete: function() {
                                                // Réactivez le bouton une fois que la requête AJAX est terminée
                                                $(".valider").prop('disabled',
                                                    false);
                                            }
                                        });
                                        console.log("check");
                                    } else {
                                        // Le compte à rebours est terminé, mais le statut n'est toujours pas bon
                                        console.log(
                                            'Compte à rebours terminé, mais statut incorrect'
                                        );
                                        // Faites ce que vous devez faire lorsque le statut n'est pas bon à la fin du compte à rebours
                                        // Par exemple, affichez un message d'erreur ou effectuez une autre action

                                        // Arrêtez le compte à rebours
                                        clearInterval(checkInterval);

                                        var flash =
                                            "<div class='alert alert-warning show mb-2' role='alert'>Paiement non validée !</div>"
                                        $('#flash-message').append(flash);

                                        $(".valider").prop('disabled', false);
                                    }
                                }, 5000);

                                $(".valider").prop('disabled',
                                    false);
                            } else {
                                link = result.data.link;
                                linkElement.text(link);
                                var shareElement = $("#link-share");
                                // Modifiez l'attribut href avec le nouveau lien
                                shareElement.attr("href", "mailto:" + email);
                                const form = tailwind.Modal.getInstance(document.querySelector(
                                    "#pay-expedition-" + id));
                                form.hide();
                                const success = tailwind.Modal.getInstance(document.querySelector(
                                    "#link-response"));
                                success.show();

                                $(".valider").prop('disabled', false);
                            }
                        }
                        $(".valider").prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        // Une erreur s'est produite lors de la requête AJAX
                        console.log(
                            'Erreur lors de la requête AJAX : ' +
                            error);
                        // Continuez le compte à rebours même en cas d'erreur
                        $(".valider").prop('disabled', false);
                    },
                    complete: function() {
                        // Réactivez le bouton une fois que la requête AJAX est terminée
                        $(".valider").prop('disabled', false);
                    }
                });
            }
        });


        function reloadPage() {
            location.reload();
        }
    </script>
@endpush
