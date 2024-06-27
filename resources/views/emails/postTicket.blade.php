<x-mail::message>
    # Introduction {{ $data['titre'] }}
    The body of your message.

    Nouveau ticket ouvert : {{ $data['titre'] }}
    Bonjour {{ $data['client'] }}
    Votre ticket est suivis par notre technicien : {{ $data['t_nom'] }} {{ $data['t_prenom'] }}
    Thanks,<br>
</x-mail::message>
