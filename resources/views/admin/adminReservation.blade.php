@extends('layouts.admin')

@section('page-content')

    <div class="col-span-12 2xl:col-span-12">
        <h2 class="intro-y text-lg font-medium mt-10">
            Réservations
        </h2>
        <div class="grid grid-cols-12 gap-12 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

                <div class="hidden md:block mx-auto text-slate-500">
                    Affiche de 1 a 10 sur {{ $reservations->count() }} réservations
                </div>

                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <form id="search-reservation" action="" method="GET" class="d-none">
                            @csrf
                            <input type="text" name="q" class="form-control w-56 box pr-10"
                                placeholder="Recherche...">
                            <a href=""
                                onclick="event.preventDefault(); document.getElementById('search-reservation').submit();">
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
                            <th class="whitespace-nowrap text-center">SUIVI</th>
                            <th class="text-center whitespace-nowrap">DATE</th>
                            <th class="text-center whitespace-nowrap">MODE</th>
                            <th class="text-center whitespace-nowrap">EXPEDITEUR</th>
                            <th class="text-center whitespace-nowrap">DESTINATAIRE</th>
                            <th class="text-center whitespace-nowrap">COUT TOTAL</th>
                            <th class="text-center whitespace-nowrap">AGENT</th>
                            <th class="text-center whitespace-nowrap">STATUT FACTURE</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" id="id">
                        @if ($reservations->count() > 0)
                            @foreach ($reservations as $reservation)
                                @php
                                    $reservation->load(['agent']);
                                @endphp
                                <tr class="intro-x">
                                    <td class="text-center bg-primary">
                                        {{ $reservation->code }}
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($reservation->created_at)->translatedFormat('d-m-Y') }}
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="text-md px-1 bg-{{ $reservation->mode_expedition_id == 2 ? 'danger' : 'primary' }} text-white mr-1"
                                            style="padding:5px; font-weight: 600;">
                                            {{ $reservation->mode->libelle ?? '' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">
                                            {{ $reservation->name_exp }}
                                        </a>
                                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                            {{ $reservation->adresse_exp }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="font-medium whitespace-nowrap">
                                            {{ $reservation->name_dest }}
                                        </a>
                                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                            {{ $reservation->adresse_dest }}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        {{ $reservation->amount ? number_format($reservation->amount, 0, ',', ' ') : 0 }}
                                        XAF
                                    </td>

                                    <td class="text-center">
                                        {{ $reservation->agent->name ?? 'Non Assigné' }}
                                    </td>

                                    <td class="w-40">
                                        @if ($reservation->status == 3)
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
                                                        <li>
                                                            <a href="javascript:;" data-tw-toggle="modal"
                                                                data-tw-target="#assign-{{ $reservation->id }}"
                                                                class="dropdown-item"
                                                                onclick="listeAgent({{ $reservation->id }})">Assigner
                                                                un agent</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="assign-{{ $reservation->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('adminReservationAgentAssign') }}">
                                                @csrf
                                                <!-- BEGIN: Modal Header -->
                                                <div class="modal-header">
                                                    <h2 class="font-medium text-base mr-auto">Assigner un Agent
                                                    </h2>
                                                </div> <!-- END: Modal Header -->
                                                <!-- BEGIN: Modal Body -->
                                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                                    <input type="hidden" name="reservation"
                                                        value="{{ $reservation->id }}">
                                                    <input type="hidden" id="agence_id-{{ $reservation->id }}"
                                                        value="{{ $reservation->agence_exp_id }}">

                                                    <div class="col-span-12 sm:col-span-12">
                                                        <label for="modal-form-6" class="form-label">Agent</label>
                                                        <select id="agent-{{ $reservation->id }}" class="form-select"
                                                            name="agent">
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
                        @endif
                    </tbody>
                </table>
                @if ($reservations->count() == 0)
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
                    {{ $reservations->links() }}
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
        function listeAgent(id) {
            var agence_id = $('#agence_id-' + id).val();
            $.ajax({
                url: "{{ route('adminSelect') }}",
                data: {
                    'target': "agent",
                    'type': "resevation",
                    'agence': agence_id,
                },
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                    result = JSON.parse(result);
                    var option_html = "<option value='-1'>Choisir</option>";
                    for (i = 0; i < result.length; i++) {
                        //is_selected = $("#agent").data('val') == result[i].id ? 'selected' : '';
                        option_html += "<option value='" + result[i].id + "'>" + result[i].name +
                            "</option>";
                    }
                    console.log(option_html);
                    $("#agent-" + id).html(option_html);
                }
            });
        }
    </script>
@endpush
