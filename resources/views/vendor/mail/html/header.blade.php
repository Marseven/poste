@props(['url'])
<tr>
    <td class="header">
        <a href="{{ config('app.url') }}" style="display: inline-block;">
            <img src="{{ URL::to('assets/dist/images/logos/icon_bleu.png') }}" class="logo" alt="La Poste Logo">
        </a>
    </td>
</tr>
