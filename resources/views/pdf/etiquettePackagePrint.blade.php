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
            font-size: 12px;
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
                <img src="{{ URL::to('front/imgs/laposte.png') }}" alt="" width="80" /> <br>
                <h2 style="color: #204897">ETIQUETTE <br>#{{ $expedition->reference }}</h2>
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
    @php
        $package->load(['agence_exp', 'agence_dest']);
    @endphp
    <table width="100%">
        <tr>
            <td align="left">
                <h3>Lieu de départ : </h3>
                <p>
                    <strong style="color: #204897"> {{ $package->agence_exp->libelle }} </strong><br>
                </p>
            </td>
            <td align="right">
                <h3>Lieu d'arrivé : </h3>
                <p>
                    <strong style="color: #204897"> {{ $package->agence_dest->libelle }} </strong><br>
                </p>
            </td>
        </tr>

    </table>
    <table width="100%">
        <tr>
            <td align="left">
                <h3>Informations supplementaires</h3>
                <p>
                    <strong>Mode</strong> : -
                </p>
            </td>

            <td align="right">
                <p>
                    <img src="{{ URL::to('code-qr/' . $package->id . '.png') }}" alt="" width="50" />
                </p>
            </td>
        </tr>

    </table>

</body>

</html>
