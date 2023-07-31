@component('mail::message')
    <h1>Bonjour M./Mme. {{ $expedition->name_exp }},</h1>

    Cliquez sur le bouton ci-dessous pour payer l'expédition N° {{ $expedition->reference }}.

    <x-mail::button :url="$link">
        Payer l'expédition
    </x-mail::button>

    Cordialement,
    La Poste Gaboanaise
@endcomponent
