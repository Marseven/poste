<!Doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $page_title }}</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        h3 {
            margin-bottom: -5px;
        }

        .gray {
            background-color: lightgray
        }
    </style>

</head>

<body>

    <table width="100%">
        <tr>
            <td valign="top">
                <img src="{{ URL::to('front/imgs/laposte.png') }}" alt="" width="150" /> <br>
                <h2 style="color: #204897">FACTURE <br>#{{ $expedition->reference }}</h2>
                @php
                    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                @endphp
                <img src="{{ URL::to('code-qr/' . $expedition->code . '.png') }}" alt="" width="100" />
                <br>
            </td>
            <td align="right">
                <h2 style="color: #204897">{{ $societe->name }}</h2>
                <p>
                    {{ $societe->email }} <br>
                    {{ $societe->phone1 }}, {{ $societe->phone2 }} <br>
                    {{ $societe->website }} <br>
                    {{ $societe->adresse }} <br>
                </p>
            </td>
        </tr>
    </table>
    <br><br>
    <table width="100%">
        <tr>
            <td align="left">
                <h3>Expéditeur : </h3>
                <p>
                    <strong style="color: #204897"> {{ $expedition->name_exp }} </strong><br>
                    {{ $expedition->email_exp }} <br>
                    {{ $expedition->phone_exp }} <br>
                    {{ $expedition->adresse_exp }} <br>
                </p>
            </td>
            <td align="right">
                <h3>Destinataire : </h3>
                <p>
                    <strong style="color: #204897"> {{ $expedition->name_dest }} </strong><br>
                    {{ $expedition->email_dest }} <br>
                    {{ $expedition->phone_dest }} <br>
                    {{ $expedition->adresse_dest }} <br>
                </p>
            </td>
        </tr>

    </table>

    <br />

    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr>
                <th>SERVICE</th>
                <th>LIBELLE</th>
                <th>POIDS</th>
                <th>PRIX</th>
            </tr>
        </thead>
        <tbody>

            @if ($paquets->count() > 0)
                @foreach ($paquets as $paquet)
                    @php
                        $paquet->load(['service']);
                    @endphp
                    <tr>
                        <td>
                            {{ $paquet->service->libelle }}
                        </td>
                        <td>
                            {{ $paquet->libelle }}
                        </td>
                        <td align="right">
                            {{ $paquet->poids }} KG(s)
                        </td>
                        <td align="right">
                            {{ $paquet->amount }} FCFA
                        </td>
                    </tr>
                @endforeach
            @endif

        </tbody>
        <br><br>
        <tfoot>
            <tr>
                <td colspan="2"></td>
                <td align="right">Sous Total</td>
                <td align="right">{{ $expedition->amount }} FCFA</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td align="right">Taxe</td>
                <td align="right">0%</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td align="right">Total</td>
                <td align="right" class="gray" style="color: #204897">{{ $expedition->amount }} FCFA</td>
            </tr>
        </tfoot>
    </table>
    <br>
    <table width="100%">
        <tr>
            <div class="text-base text-slate-500"></div>
            <div class="mt-1">


            </div>
            <td align="left">
                <h3>Informations supplementaires</h3>
                <p>
                    <strong>Mode</strong> : <span
                        style="padding:5px; font-weight: 600; color: white; background-color:{{ $expedition->mode_exp_id == 2 ? 'red' : '#204897' }}">
                        {{ $expedition->mode->libelle }}</span>

                    {{ $expedition->mode_exp_id ? $expedition->mode->libelle : 'Non defini' }}
                    <br>
                </p>
            </td>

            <td align="right">
                <p>
                    <strong>Date</strong> :
                    {{ \Carbon\Carbon::parse($expedition->created_at)->translatedFormat('l jS F Y') }}
                </p>
                <br>
                <p> <strong>Signature Client</strong> : ____________________________________
                </p>
            </td>
        </tr>

    </table>
    <br>
    <table width="100%">
        <tr>
            <td>
                <h3>Conditions</h3>
                <br>
            </td>
        </tr>
        <tr>
            <td style="text-align: justify">
                L'expéditeur déclare qu'il n'envoie pas d'argent, d'explosifs, d'armes, de bijoux ou de produits
                chimiques. En cas de saisie de la marchandise par les autorités douanières, le paiement des taxes
                sera à la charge du client. {{ $societe->name }} répondra pour la valeur entre 0,00 XAF et 100 000 XAF
                selon l'évaluation et les critères assignés par l'entreprise. {{ $societe->name }} n'est pas
                responsable
                de la casse ou de l'endommagement de la marchandise. Le client autorise l'agent à avoir un contact
                visuel avec la boîte (revoir) son contenu.
            </td>
        </tr>

    </table>

</body>

</html>
