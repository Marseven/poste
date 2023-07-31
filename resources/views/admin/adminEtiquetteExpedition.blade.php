@extends('layouts.admin')

@section('page-content')
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Etiquette Expedition
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('EtiquettePrint', ['code' => $expedition->code]) }}"
                class="btn btn-primary shadow-md mr-2">Imprimer</a>
        </div>
    </div>
    <!-- BEGIN: Invoice -->
    <div class="intro-y box overflow-hidden mt-5">
        <div class="flex flex-col lg:flex-row pt-10 px-5 sm:px-20 sm:pt-20 lg:pb-20 text-center sm:text-left">
            <div class="font-semibold text-primary text-3xl">
                ETIQUETTE
                <div class="text-xl text-primary font-medium">{{ $expedition->reference }}</div>

                @php
                    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                @endphp
                <div class="mt-1">
                    {!! $generator->getBarcode($expedition->code, $generator::TYPE_CODE_128) !!}
                </div>
            </div>
            <div class="mt-20 lg:mt-0 lg:ml-auto lg:text-right">
                <div class="text-xl text-primary font-medium">
                    {{ $societe->name }}
                </div>
                <div class="mt-1">{{ $societe->email }}</div>
                <div class="mt-1">{{ $societe->phone1 }}, {{ $societe->phone2 }}</div>
                <div class="mt-1">{{ $societe->website }}</div>
                <div class="mt-1">{{ $societe->adresse }}</div>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row border-b px-5 sm:px-20 pt-10 pb-10 sm:pb-20 text-center sm:text-left">
            <div>
                <div class="text-base text-slate-500">Expediteur Details</div>
                <div class="text-lg font-medium text-primary mt-2">{{ $expedition->name_exp }}</div>
                <div class="mt-1">{{ $expedition->email_exp }}</div>
                <div class="mt-1">{{ $expedition->phone_exp }}</div>
                <div class="mt-1">{{ $expedition->adresse_exp }}</div>
            </div>
            <div class="mt-10 lg:mt-0 lg:ml-auto lg:text-right">
                <div class="text-base text-slate-500">Destinataire Details</div>
                <div class="text-lg font-medium text-primary mt-2">{{ $expedition->name_dest }}</div>
                <div class="mt-1">{{ $expedition->email_dest }}</div>
                <div class="mt-1">{{ $expedition->phone_dest }}</div>
                <div class="mt-1">{{ $expedition->adresse_dest }}</div>
            </div>
        </div>
        <br><br>
        <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
            <div class="text-center sm:text-left mt-10 sm:mt-0">
                <div class="text-base text-slate-500">Informations supplementaires</div>
                <div class="mt-1">
                    <strong>Mode</strong> :
                    <span
                        class="text-md px-1 bg-{{ $expedition->mode_exp_id == 2 ? 'danger' : 'primary' }} text-white mr-1"
                        style="padding:5px; font-weight: 600;">
                        {{ $expedition->mode->libelle }}</span>
                </div>

            </div>
            <div class="text-center sm:text-right sm:ml-auto">
                <div class="mt-1">
                    {!! QrCode::size(100)->generate($expedition->code) !!}
                </div>
            </div>
        </div>

    </div>
    <!-- END: Invoice -->
@endsection
