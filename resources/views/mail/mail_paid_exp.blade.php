@component('mail::message')
    @php
        $payment->load(['expedition']);
        $expedition = $payment->expedition;
    @endphp
    <h1>Bonjour M./Mme. {{ $expedition->name_exp }},</h1>

    Votre paiement a bien été reçu pour l'expédition N° {{ $expedition->reference }}. Le numéro de transaction opérateur est
    {{ $payment->transaction_id }}.

    Cordialement,
    La Poste Gaboanaise
@endcomponent
