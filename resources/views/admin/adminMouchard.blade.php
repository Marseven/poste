@extends('layouts.admin')

@section('page-content')

    <div class="col-span-12 2xl:col-span-12">
        <h2 class="intro-y text-lg font-medium mt-10">
            Logs Systeme
        </h2>
        <div class="grid grid-cols-12 gap-12 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">


                <div class="hidden md:block mx-auto text-slate-500">
                    Affiche de 1 a 10 sur {{ $mouchards->count() }} logs
                </div>

                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <form id="search-compte" action="{{ route('adminSearchMouchard') }}" method="GET" class="d-none">
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
            <div class="intro-y col-span-12 overflow-auto ">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">AUTEUR</th>
                            <th class="whitespace-nowrap">TITRE</th>
                            <th class="whitespace-nowrap">ACTION</th>
                            <th class="whitespace-nowrap text-center">IP ADRESSE</th>
                            <th class="text-center whitespace-nowrap">OS SYSTEME</th>
                            <th class="text-center whitespace-nowrap">NAVIGATEUR</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($mouchards)
                            @foreach ($mouchards as $mouchard)
                                <tr class="intro-x">
                                    <td class="text-center">
                                        {{ $mouchard->action_author }}
                                    </td>
                                    <td class="text-center">
                                        {{ $mouchard->action_title }}
                                    </td>
                                    <td class="text-center">
                                        {{ $mouchard->action_system }}
                                    </td>
                                    <td class="text-center">
                                        {{ $mouchard->ip_adresse }}
                                    </td>
                                    <td class="text-center">
                                        {{ $mouchard->os_system }}
                                    </td>
                                    <td class="text-center">
                                        {{ $mouchard->os_navigator }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        @endif


                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->
            <!-- BEGIN: Pagination -->
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                <nav class="w-full sm:w-auto sm:mr-auto">
                    {{ $mouchards->links() }}
                </nav>
            </div>
            <!-- END: Pagination -->
        </div>

    </div>




@endsection
