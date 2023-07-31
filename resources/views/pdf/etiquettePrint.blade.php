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
    <table width="100%">
        <tr>
            <td align="left">
                <h3>Informations supplementaires</h3>
                <p>
                    <strong>Mode</strong> : <span
                        style="padding:5px; font-weight: 600; color: white; background-color:{{ $expedition->mode_exp_id == 2 ? 'red' : '#204897' }}">
                        {{ $expedition->mode->libelle }}</span><br>
                </p>
            </td>

            <td align="right">
                <p>
                    <img src="{{ URL::to('code-qr/' . $expedition->code . '.png') }}" alt="" width="50" />
                </p>
            </td>
        </tr>

    </table>

</body>

</html>
