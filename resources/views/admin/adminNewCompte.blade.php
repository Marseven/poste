@extends('layouts.admin')

@section('page-content')
    @csrf

    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Nouveau Compte
        </h2>
    </div>


    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Profile Menu -->
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">

            <div class="intro-y box bg-warning mt-5 lg:mt-0">
                <div class="relative flex items-center p-5">
                    <div class="ml-4 mr-auto">
                        <div class="font-medium text-base">Note d'information</div>
                        <br>
                        <div class="text-black">
                            <strong><u>NB</u></strong> : Cher agent, la creation de compte n'est valable que pour les
                            employes et les administrateurs ou superieurs de la societe. Aucun compte client ne doit etre
                            creer a partir de cette interface.
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- END: Profile Menu -->

        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">

            <form method="POST" action="{{ route('adminAddCompte') }}">

                @csrf

                <!-- BEGIN: Daily Sales -->
                <div class="intro-y box col-span-12 2xl:col-span-6">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            Formaulaire de Creation de Compte
                        </h2>
                    </div>
                    <div class="p-5 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-1" class="form-label">Noms*</label>
                            <input type="text" class="form-control" placeholder="Ex. NDONG" name="noms" required>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-1" class="form-label">Prenoms*</label>
                            <input type="text" class="form-control" placeholder="Ex. Paul" name="prenoms" required>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-1" class="form-label">Email*</label>
                            <input type="text" class="form-control" placeholder="Ex. paul.ndong@gmail.com"
                                name="email">
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-1" class="form-label">Mot de Passe*</label>
                            <input type="text" readonly class="form-control" name="password" value="laposte@agent">
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-1" class="form-label">Telephone*</label>
                            <input type="text" class="form-control" placeholder="Ex. +241 74 00 00 01" name="phone"
                                required>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-1" class="form-label">Adresse*</label>
                            <input type="text" class="form-control" placeholder="Ex. Face CKDO Oloumi" name="adresse"
                                required>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-1" class="form-label">Droits d'acces*</label>
                            <select id="modal-form-6" class="form-select" name="role">
                                <option value="Agent">Agent</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-1" class="form-label">Droits d'acces*</label>
                            <select id="modal-form-6" class="form-select" name="agence_id">
                                @foreach ($agences as $agence)
                                    <option value="{{ $agence->id }}">{{ $agence->libelle }}</option>
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

                        <button type="submit" class="btn btn-primary w-20">Soumettre</button>


                    </div>
                </div>
                <!-- END: Daily Sales -->

            </form>
        </div>
    </div>
@endsection
