@component('mail::message')
    <h1>Bonjour M./Mme. {{ $expedition->name_exp }},</h1>

    Cliquez sur le bouton ci-dessous pour payer l'expédition N° {{ $expedition->reference }}.

    @component('mail::button', ['url' => $link])
        Payer l'expédition
    @endcomponent

    Cordialement,
    La Poste Gaboanaise
@endcomponent
