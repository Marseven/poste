@component('mail::message')
    <h1>Bonjour M./Mme. {{ $expedition->name_exp }},</h1>

    Cliquez sur le bouton ci-dessous pour payer l'expédition N° {{ $expedition->reference }}.

    <a href="{{ $link }}" target="_blank">Payer l'expédition</a>

    Cordialement,
    La Poste Gaboanaise
@endcomponent
