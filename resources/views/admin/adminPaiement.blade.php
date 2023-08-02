@extends('layouts.admin')

@section('page-content')
    <div class="col-span-12 2xl:col-span-12">
        <h2 class="intro-y text-lg font-medium mt-10">
            Liste de Paiements
        </h2>
        <div class="grid grid-cols-12 gap-12 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

                <div class="hidden md:block mx-auto text-slate-500">
                    Affiche de 1 a 10 sur {{ $payments->count() }} Paiements
                </div>

                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <form id="search-paiements" action="{{ route('adminSearchPaiement') }}" method="GET" class="d-none">
                            @csrf
                            <input type="text" name="q" class="form-control w-56 box pr-10"
                                placeholder="Recherche...">
                            <a href=""
                                onclick="event.preventDefault(); document.getElementById('search-paiements').submit();">
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
                            <th class="whitespace-nowrap text-center">REFERENCE</th>
                            <th class="text-center whitespace-nowrap">EXPEDITION</th>
                            <th class="text-center whitespace-nowrap">MONTANT</th>
                            <th class="text-center whitespace-nowrap">OPERATEUR</th>
                            <th class="text-center whitespace-nowrap">DATE</th>
                            <th class="text-center whitespace-nowrap">STATUT</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($payments)
                            @foreach ($payments as $pay)
                                <tr class="intro-x">
                                    <td class="text-center">
                                        {{ $pay->reference }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('adminFactureExpedition', ['code' => $pay->expedition->code]) }}">
                                            {{ $pay->expedition->code }}</a>
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($pay->amount, 0, ',', ' ') }} XAF
                                    </td>
                                    <td class="text-center">
                                        {{ $pay->operator }}
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($pay->paid_at)->translatedFormat('d-m-Y') }}
                                    </td>
                                    <td class="w-40">
                                        @if ($pay->status == 3)
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Payé </div>
                                        @else
                                            <div class="flex items-center justify-center text-primary"> <i
                                                    data-lucide="check-square" class="w-4 h-4 mr-2"></i> Non Payé </div>
                                        @endif
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
                    {{ $payments->links() }}
                </nav>
            </div>
            <!-- END: Pagination -->
        </div>

    </div>
@endsection
