<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="UTF-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Découvrez les différentes 
        spécificités d'envoi d'un colis au Gabon : Délais indicatifs 
        de livraison, formalités douaniéres, restrictions particuliéres" />

        <link href="{{ URL::to('assets/dist/images/logos/icon_bleu.png') }}" rel="shortcut icon">

        <!-- A propos du Dev -->
        <meta name="auteur" content="Yannick ABOH">
        <meta name="status" content="Ingénieur Logiciel, Freelance">
        <meta name="email" content="yannickabohthierry@gmail.com">
        <meta name="whatsapp" content="(+241) 074 83 56 31 | 066 68 23 53 | (+237) 697 57 30 41">

        <title>{{ $app_name ? $app_name : "LA POSTE" }} | {{ $page_title ? $page_title : "" }}</title>


        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ URL::to('assets/dist/css/app.css') }}" />
        <!-- END: CSS Assets-->



    </head>
    <!-- END: Head -->
    <body class="py-5" onload="window.print();">
        <div class="flex mt-[4.7rem] md:mt-0">
            

            <!-- BEGIN: Content -->
            <div class="content">
                <div class="col-span-12 2xl:col-span-12">
                    @yield('page-content')
                </div>
            </div>
            <!-- END: Content -->
            
        </div>
        
        <!-- BEGIN: JS Assets-->
        <script src="{{ URL::to('assets/dist/js/app.js') }}"></script>
        <!-- END: JS Assets-->
    </body>
</html>