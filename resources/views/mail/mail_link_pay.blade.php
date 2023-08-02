@component('mail::message')
    <h1>Bonjour M./Mme. {{ $expedition->name_exp }},</h1>

    Cliquez sur le lien ci-dessous pour payer l'expédition N° {{ $expedition->reference }}.

    {{ $link }}

    Cordialement,
    La Poste Gaboanaise
@endcomponent
