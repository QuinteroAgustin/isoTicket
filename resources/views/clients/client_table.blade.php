<!-- clients/client_table.blade.php -->
<div id="clientTable">
    <table class="min-w-full table-auto">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Intitulé</th>
                <th class="py-3 px-6 text-center">Téléphone</th>
                <th class="py-3 px-6 text-center">Adresse</th>
                <th class="py-3 px-6 text-center">Ville</th>
                <th class="py-3 px-6 text-center">Code postal</th>
                <th class="py-3 px-6 text-center">Siret</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach ($clients as $client)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $client->CT_Num }}</td>
                    <td class="py-3 px-6 text-left">{{ $client->CT_Intitule }}</td>
                    <td class="py-3 px-6 text-center">{{ $client->CT_Telephone }}</td>
                    <td class="py-3 px-6 text-center">{{ $client->CT_Adresse }}</td>
                    <td class="py-3 px-6 text-center">{{ $client->CT_Ville }}</td>
                    <td class="py-3 px-6 text-center">{{ $client->CT_CodePostal }}</td>
                    <td class="py-3 px-6 text-center">{{ $client->CT_Site }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
