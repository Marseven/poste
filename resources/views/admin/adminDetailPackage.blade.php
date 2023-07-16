@extends('layouts.admin')

@section('page-content')



    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Package - {{ $package->code }}
        </h2>

        <div class="ml-auto flex items-center">
            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-colis"
                class="btn btn-warning shadow-md mr-2">Ajouter
                Colis</a>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Profile Menu -->
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">

            <div class="intro-y box  bg-warning text-black mt-5 lg:mt-0">
                <div class="relative flex items-center p-5">
                    <div class="ml-4 mr-auto">
                        <div class="font-medium text-base">Note d'information</div>
                        <br>
                        <div class="text-black">
                            <strong><u>NB</u></strong> : Il est important de rappeller que les assignations de colis se font
                            a partir de 14h30 et ne sont operationnels que le jour meme. donc passer la date d'aujourd'hui,
                            le systeme ne permettra aucune assignation de colis.
                        </div>
                    </div>
                </div>
            </div>

            <div class="intro-y box p-5 bg-warning text-black mt-5">
                <div class="flex items-center">
                    <div class="font-medium text-lg">Types de packages</div>
                </div>
                <div class="mt-4">
                    1. Type 1 [ Agence vers CNT ] <br>
                    2. Type 2 [ CNT vers Agence ] <br>
                </div>

            </div>


        </div>
        <!-- END: Profile Menu -->



        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <!-- BEGIN: File Manager Filter -->
            <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
                <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                    <input type="text" class="form-control w-full sm:w-64 box px-10" placeholder="Rechercher colis...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-slate-500" data-lucide="search"></i>
                </div>
            </div>
            <!-- END: File Manager Filter -->

            <!-- BEGIN: Directory & Files -->
            <div id="content-colis" class="intro-y grid grid-cols-12 gap-3 sm:gap-6 mt-5">

                @if ($today_paquets)
                    @foreach ($today_paquets as $paquet)
                        <div class="intro-y col-span-6 sm:col-span-4 md:col-span-4 2xl:col-span-4">
                            <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" icon-name="package" data-lucide="package"
                                    class="lucide lucide-package block mx-auto">
                                    <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                                    <path
                                        d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z">
                                    </path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                                <a href="" class="block font-medium mt-4 text-center truncate">
                                    {{ $paquet->libelle }}
                                </a>
                                <div class="text-slate-500 text-xs text-center mt-0.5">
                                    {{ $paquet->code }}
                                </div>
                                <div class="text-slate-500 text-xs text-center mt-0.5">
                                    @if ($paquet->active == 1)
                                        <div class="flex items-center justify-center text-primary"> Enregistre(e) </div>
                                    @elseif($paquet->active == 2)
                                        <div class="flex items-center justify-center text-success"> Assigne(e) </div>
                                    @elseif($paquet->active == 3)
                                        <div class="flex items-center justify-center text-success"> CNT </div>
                                    @elseif($paquet->active == 4)
                                        <div class="flex items-center justify-center text-success"> Expedie(e) </div>
                                    @elseif($paquet->active == 5)
                                        <div class="flex items-center justify-center text-success"> Livre(e) </div>
                                    @else
                                        <div class="flex items-center justify-center text-warning"> Non defini </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- BEGIN: Delete Confirmation Modal -->

                        <!-- END: Delete Confirmation Modal -->
                    @endforeach
                @else
                    <div class="alert alert-pending show flex items-center mb-2" role="alert"> <i
                            data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i> Aucun colis pour le moment ! </div>
                @endif


            </div>
            <!-- END: Directory & Files -->

            <!-- BEGIN: Pagination -->
            {{-- <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-6">
                <nav class="w-full sm:w-auto sm:mr-auto">
                    {{ $today_paquets->links() }}
                </nav>
            </div> --}}
            <!-- END: Pagination -->


            <!-- BEGIN: Delete Confirmation Modal -->
            <div id="add-colis" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="form-colis">
                            <!-- BEGIN: Modal Header -->
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">Ajouter un colis</h2>
                            </div> <!-- END: Modal Header -->
                            <!-- BEGIN: Modal Body -->
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12 sm:col-span-12">
                                    <label for="modal-form-6" class="form-label">Le colis</label>
                                    <select id="colis" name="colis[]" data-placeholder="Choisissez les colis"
                                        class="tom-select w-full" multiple>
                                        @foreach ($today_paquets as $paquet)
                                            <option value="{{ $paquet->id }}">{{ $paquet->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="package" value="{{ $package->id }}" id="package">
                            </div> <!-- END: Modal Body -->
                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer">
                                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#confirm"
                                    class="btn btn-primary w-20"> <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                                    Assigner </a>
                            </div>
                            <!-- END: Modal Footer -->
                        </form>
                    </div>
                </div>
            </div>
            <!-- END: Delete Confirmation Modal -->

            <div id="confirm" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- BEGIN: Modal Header -->
                        <div class="modal-header">
                            <h2 class="font-medium text-base mr-auto">Confirmation Assignation</h2>
                        </div>
                        <!-- END: Modal Header -->

                        <!-- BEGIN: Modal Body -->
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-6">
                                <p>
                                    Etes-vous sur de vouloir assigner ces colis au package
                                    {{ $package->code }} ?
                                </p>
                            </div>

                        </div>
                        <!-- END: Modal Body -->

                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer">
                            <button onclick="assign()" class="btn btn-primary w-20">Confirmer</button>
                        </div>
                        <!-- END: Modal Footer -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function assign() {

            var colis = $("#colis").val();
            var package = $("#package").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('adminPackageAssign') }}", // Chemin vers votre script PHP de traitement
                type: 'POST',
                data: {
                    colis: colis,
                    package: package,
                },
                success: function(result) {
                    console.log(result);
                    result = JSON.parse(result);
                    var option_html = "<option value='0'>Choisir</option>";
                    for (i = 0; i < result.length; i++) {
                        is_selected = $("#" + target).data('val') == result[i].id ? 'selected' : '';
                        option_html += "<option " + is_selected + "  value='" + result[i].id + "'>" +
                            result[i].name +
                            "</option>";
                    }
                }
            });
        }
    </script>
@endpush
