@extends('layouts.admin')

@section('page-content')

    <div class="col-span-12 2xl:col-span-12">
        <h2 class="intro-y text-lg font-medium mt-10">
            Liste des Comptes
        </h2>
        <div class="grid grid-cols-12 gap-12 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">


                <div class="hidden md:block mx-auto text-slate-500">
                    Affiche de 1 a 10 sur {{ $comptes->count() }} comptes
                </div>

                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <form id="search-compte" action="{{ route('adminSearchCompte') }}" method="GET" class="d-none">
                            @csrf
                            <input type="text" name="q" class="form-control w-56 box pr-10"
                                placeholder="Recherche...">
                            <a href=""
                                onclick="event.preventDefault(); document.getElementById('search-compte').submit();">
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
                            <th class="whitespace-nowrap">AVATAR</th>
                            <th class="whitespace-nowrap">NOM COMPLET</th>
                            <th class="whitespace-nowrap text-center">EMAIL</th>
                            <th class="text-center whitespace-nowrap">TELEPHONE</th>
                            <th class="text-center whitespace-nowrap">ROLE</th>
                            <th class="text-center whitespace-nowrap">AGENCE</th>
                            <th class="text-center whitespace-nowrap">STATUT</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($comptes)
                            @foreach ($comptes as $compte)
                                @php
                                    $compte->load(['agence']);
                                @endphp
                                <tr class="intro-x">
                                    <td class="w-40">
                                        <div class="flex text-center">
                                            <div class="w-10 h-10 image-fit zoom-in text-center">
                                                <img class="rounded-full text-center" src="{{ $compte->avatar }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        {{ $compte->name }}
                                    </td>
                                    <td class="text-center">
                                        {{ $compte->email }}
                                    </td>
                                    <td class="text-center">
                                        {{ $compte->phone }}
                                    </td>
                                    <td class="text-center">
                                        {{ $compte->role }}
                                    </td>
                                    <td class="w-40">
                                        {{ $compte->agence_id ? $compte->agence->libelle ?? '' : 'Non defini' }}
                                    </td>
                                    <td class="w-40">
                                        @if ($compte->active == 1)
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
                                                data-tw-target="#update-{{ $compte->id }}"> <i data-lucide="edit"
                                                    class="w-4 h-4 mr-1"></i> </a>
                                            <a class="flex items-center mr-3" href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#avatar-{{ $compte->id }}"> <i data-lucide="camera"
                                                    class="w-4 h-4 mr-1"></i> </a>
                                        </div>
                                    </td>
                                </tr>


                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="update-{{ $compte->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('adminEditCompte') }}">
                                                @csrf
                                                <!-- BEGIN: Modal Header -->
                                                <div class="modal-header">
                                                    <h2 class="font-medium text-base mr-auto">Formulaire de Modification
                                                    </h2>
                                                </div> <!-- END: Modal Header -->
                                                <!-- BEGIN: Modal Body -->
                                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <input type="hidden" name="compte_id" value="{{ $compte->id }}">
                                                        <label for="modal-form-1" class="form-label">Noms*</label>
                                                        <input type="text" class="form-control" placeholder="Ex. NDONG"
                                                            name="noms" required value="{{ $compte->noms }}">
                                                    </div>
                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-1" class="form-label">Prenoms*</label>
                                                        <input type="text" class="form-control" placeholder="Ex. Paul"
                                                            name="prenoms" required value="{{ $compte->prenoms }}">
                                                    </div>
                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-1" class="form-label">Email*</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Ex. paul.ndong@gmail.com" name="email"
                                                            value="{{ $compte->email }}">
                                                    </div>
                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-1" class="form-label">Mot de Passe*</label>
                                                        <input type="text" readonly class="form-control"
                                                            name="password" value="laposte@agent">
                                                    </div>
                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-1" class="form-label">Telephone*</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Ex. +241 74 00 00 01" name="phone" required
                                                            value="{{ $compte->phone }}">
                                                    </div>
                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-1" class="form-label">Adresse*</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Ex. Face CKDO Oloumi" name="adresse" required
                                                            value="{{ $compte->adresse }}">
                                                    </div>
                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-1" class="form-label">Droits
                                                            d'acces*</label>
                                                        <select id="modal-form-6" class="form-select" name="role">
                                                            <option value="Agent">Agent</option>
                                                            <option value="Admin">Admin</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-span-12 sm:col-span-6">
                                                        <label for="modal-form-1" class="form-label">Droits
                                                            d'acces*</label>
                                                        <select id="modal-form-6" class="form-select" name="agence_id">
                                                            @foreach ($agences as $agence)
                                                                @if ($agence->id == $compte->agence_id)
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
                                                        <label for="modal-form-1" class="form-label">Statut*</label>
                                                        <select id="modal-form-6" class="form-select" name="active">
                                                            <option value="1">Active</option>
                                                            <option value="0">Desactive</option>
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

                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="avatar-{{ $compte->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('adminAvatarCompte') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <!-- BEGIN: Modal Header -->
                                                <div class="modal-header">
                                                    <h2 class="font-medium text-base mr-auto">Formulaire de Modification de
                                                        l'Avatar</h2>
                                                </div> <!-- END: Modal Header -->
                                                <!-- BEGIN: Modal Body -->
                                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                                    <div class="col-span-12 sm:col-span-6">
                                                        <input type="hidden" name="compte_id"
                                                            value="{{ $compte->id }}">
                                                        <label for="modal-form-1" class="form-label">Avatar*</label>
                                                        <input type="file" class="form-control" name="avatar"
                                                            required>
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
                    {{ $comptes->links() }}
                </nav>
            </div>
            <!-- END: Pagination -->
        </div>

    </div>




@endsection
