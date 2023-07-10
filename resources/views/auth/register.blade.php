<!DOCTYPE html>
<html lang="fr" class="light">
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

        <title>LA POSTE | Créer un Compte</title>


        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ URL::to('assets/dist/css/app.css') }}" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <div class="my-auto">
                        <img alt="La Poste" class="-intro-x w-1/2 -mt-16" src="{{ URL::to('assets/dist/images/logos/logo_blanc.png') }}">
                        <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                            La Poste
                        </div>
                        <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Espace réservé au personnel administratif !</div>
                    </div>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">

                    @if(Session::get('success'))
                        <div class="alert alert-success alert-dismissible alert-alt solid fade show" id="success-alert">
                            <strong>Succès!</strong> {{ Session::get('success') }}.
                        </div>
                    @endif

                    @if(Session::get('failed'))
                        <div class="alert alert-danger alert-dismissible alert-alt solid fade show" id="warning-alert">
                            <strong>Attention!</strong> {{ Session::get('failed') }}.
                        </div>
                    @endif




                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                            <br><br><br><br><br><br><br><br>
                            
                            <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                                Espace Administratif
                            </h2>
                            <div class="intro-x mt-2 text-slate-400">
                                Connectez-vous à votre tableau de bord personnel ! 
                            </div>
                            <div class="intro-x mt-8">

                                <input type="text" id="name" class="intro-x login__input form-control py-3 px-4 block" placeholder="Nom complet" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                <br>

                                <input type="email" id="email" class="intro-x login__input form-control py-3 px-4 block" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>



                                <input type="password" id="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Mot de passe" name="password" required autocomplete="current-password">

                                <input id="password-confirm" type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmation Mot de passe">

                                

                            </div>
                            
                            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Soumettre</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- END: Login Form -->
            </div>
        </div>
        
        
        <!-- BEGIN: JS Assets-->
        <script src="{{ URL::to('assets/dist/js/app.js') }}"></script>
        <!-- END: JS Assets-->
    </body>
</html>





