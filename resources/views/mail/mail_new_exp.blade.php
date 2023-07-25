@component('mail::message')
    <h1>Bonjour M./Mme. {{ $expedition->name_exp }},</h1>

    Merci pour votre confiance en La Poste Gabonaise.

    Votre expédition N° {{ $expedition->reference }} a été crée et sera enregistré pour l'expédion à
    {{ $expedition->agence_dest->libelle ?? '' }}.

    Cordialement,
    La Poste Gaboanaise
@endcomponent
