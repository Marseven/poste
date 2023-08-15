@extends('layouts.admin')

@section('page-content')
    <div class="col-span-12 2xl:col-span-12">
        <h2 class="intro-y text-lg font-medium mt-10">
            Etapes
        </h2>
        <div class="grid grid-cols-12 gap-12 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#large-modal-size-preview"
                    class="btn btn-primary shadow-md mr-2">Nouveau Etape</a>

                <!-- BEGIN: Large Modal Content -->
                <!-- BEGIN: Modal Content -->
                <div id="large-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('adminAddEtape') }}">
                                @csrf
                                <!-- BEGIN: Modal Header -->
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Formulaire d'ajout</h2>
                                </div> <!-- END: Modal Header -->
                                <!-- BEGIN: Modal Body -->
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-1" class="form-label">Code</label>
                                        <input type="text" class="form-control" placeholder="RJT" name="code"
                                            required>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-2" class="form-label">Libelle</label>
                                        <input type="text" class="form-control" placeholder="REJETE" name="libelle"
                                            required>
                                    </div>

                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="modal-form-2" class="form-label">Code Hexadecimal</label>
                                        <input type="text" class="form-control" placeholder="#23A34" name="code_hexa"
                                            required>
                                    </div>

                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="modal-form-2" class="form-label">Description</label>
                                        <textarea name="description" class="form-control" rows="4" required></textarea>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-6" class="form-label">Type</label>
                                        <select id="modal-form-6" class="form-select" name="type">
                                            <option>Expédition</option>
                                            <option>Dépêche</option>
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-6" class="form-label">Mode</label>
                                        <select id="modal-form-6" class="form-select" name="mode_id">
                                            @foreach ($modes as $mode)
                                                <option value="{{ $mode->id }}">{{ $mode->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-2" class="form-label">Position</label>
                                        <input type="number" class="form-control" name="position" class="form-control"
                                            placeholder="0">
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
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
                    Affiche de 1 a 10 sur {{ $etapes->count() }} etapes d'expedition
                </div>

                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <form id="search-etapes" action="{{ route('adminSearchEtape') }}" method="GET" class="d-none">
                            @csrf
                            <input type="text" name="q" class="form-control w-56 box pr-10"
                                placeholder="Recherche...">
                            <a href=""
                                onclick="event.preventDefault(); document.getElementById('search-etapes').submit();">
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
                            <th class="text-center whitespace-nowrap">LIBELLE</th>
                            <th class="text-center whitespace-nowrap">COULEUR</th>
                            <th class="text-center whitespace-nowrap">STATUT</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($etapes)
                            @foreach ($etapes as $etape)
                                <tr class="intro-x">
                                    <td class="text-center">
                                        {{ $etape->code }}
                                    </td>
                                    <td class="text-center">
                                        {{ $etape->libelle }}
                                    </td>
                                    <td class="text-center">
                                        {{ $etape->code_hexa }}
                                    </td>
                                    <td class="w-40">
                                        @if ($etape->active == 1)
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
                                                data-tw-target="#update-{{ $etape->id }}"> <i data-lucide="edit"
                                                    class="w-4 h-4 mr-1"></i> </a>
                                        </div>
                                    </td>
                                </tr>


                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="update-{{ $etape->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('adminEditEtape') }}">
                                                @csrf
                                                <!-- BEGIN: Modal Header -->
                                                <div class="modal-header">
                                                    <h2 class="font-medium text-base mr-auto">Formulaire de Modification
                                                    </h2>
                                                </div> <!-- END: Modal Header -->
                                                <!-- BEGIN: Modal Body -->
                                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <input type="hidden" name="service_id"
                                                            value="{{ $etape->id }}">
                                                        <label for="modal-form-1" class="form-label">Code</label>
                                                        <input type="text" class="form-control" placeholder="RJT"
                                                            name="code" value="{{ $etape->code }}">
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-2" class="form-label">Libelle</label>
                                                        <input type="text" class="form-control" placeholder="REJETE"
                                                            name="libelle" value="{{ $etape->libelle }}">
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-12">
                                                        <label for="modal-form-2" class="form-label">Code
                                                            Hexadecimal</label>
                                                        <input type="text" class="form-control" placeholder="#23A34"
                                                            name="code_hexa"value="{{ $etape->libelle }}">
                                                    </div>


                                                    <div class="col-span-12 sm:col-span-12">
                                                        <label for="modal-form-2" class="form-label">Description</label>
                                                        <textarea name="description" class="form-control" rows="4">
									                 		{{ $etape->description }}
									                 	</textarea>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-6" class="form-label">Type</label>
                                                        <select id="modal-form-6" class="form-select" name="type">
                                                            <option {{ $etape->type == 'Expédition' ? 'selected' : '' }}>
                                                                Expédition</option>
                                                            <option {{ $etape->type == 'Package' ? 'selected' : '' }}>
                                                                Dépêche</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-6" class="form-label">Mode</label>
                                                        <select id="modal-form-6" class="form-select" name="mode_id">
                                                            @foreach ($modes as $mode)
                                                                <option
                                                                    {{ $mode->id == $etape->mode_id ? 'selected' : '' }}
                                                                    value="{{ $mode->id }}">{{ $mode->libelle }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-2" class="form-label">Position</label>
                                                        <input type="number" class="form-control" name="position"
                                                            value="{{ $etape->position }}">
                                                    </div>



                                                    <div class="col-span-12 sm:col-span-6">
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
                    {{ $etapes->links() }}
                </nav>
            </div>
            <!-- END: Pagination -->
        </div>

    </div>
@endsection
