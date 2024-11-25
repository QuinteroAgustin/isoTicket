@extends('layouts.app')
@section('title', 'Information client')
@section('content')


<div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select tab</label>
        <select id="tabs" class="bg-gray-50 border-0 border-b border-gray-200 text-black text-sm rounded-t-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option>Générales</option>
            <option>Contacts</option>
            <option>Interne</option>
        </select>
    </div>
    <ul class="hidden text-sm font-medium text-center text-black divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-black rtl:divide-x-reverse" id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
        <li class="w-full">
            <button id="stats-tab" data-tabs-target="#stats" type="button" role="tab" aria-controls="stats" aria-selected="true" class="inline-block w-full p-4 rounded-ss-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Générales</button>
        </li>
        <li class="w-full">
            <button id="about-tab" data-tabs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="false" class="inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Contacts</button>
        </li>
        <li class="w-full">
            <button id="faq-tab" data-tabs-target="#faq" type="button" role="tab" aria-controls="faq" aria-selected="false" class="inline-block w-full p-4 rounded-se-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Interne</button>
        </li>
    </ul>
    <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
        <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="stats" role="tabpanel" aria-labelledby="stats-tab">
            <h2 class="mb-5 text-2xl font-extrabold tracking-tight text-black dark:text-white">Informations du client {{ $client->CT_Num }}</h2>
            <div class="grid mb-8 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 md:mb-12 md:grid-cols-2 bg-white dark:bg-gray-800">
                <figure class="flex flex-col items-center justify-center p-8 text-center bg-white border-b border-gray-200 rounded-t-lg md:rounded-t-none md:rounded-ss-lg md:border-e dark:bg-gray-800 dark:border-gray-700">
                    <blockquote class="max-w-2xl mx-auto mb-4 text-black lg:mb-8 dark:text-black">
                        <h3 class="text-lg font-semibold text-black dark:text-white">Adresse</h3>
                        <p class="my-4">{{ $client->CT_Adresse }}</p>
                        <p class="my-4">{{ $client->CT_Complement }}</p>
                        <p class="my-4">{{ $client->CT_CodePostal }}</p>
                        <p class="my-4">{{ $client->CT_Ville }}</p>
                        <p class="my-4">{{ $client->CT_Pays }}</p>
                    </blockquote>
                </figure>
                <figure class="flex flex-col items-center justify-center p-8 text-center bg-white border-b border-gray-200 md:rounded-se-lg dark:bg-gray-800 dark:border-gray-700">
                    <blockquote class="max-w-2xl mx-auto mb-4 text-black lg:mb-8 dark:text-black">
                        <h3 class="text-lg font-semibold text-black dark:text-white">Contact principal</h3>
                        <p class="my-4">{{ $client->CT_Telephone }}</p>
                        <p class="my-4">{{ $client->CT_EMail }}</p>
                        <p class="my-4">Siret : {{ $client->CT_Siret }}</p>
                    </blockquote>
                </figure>
                <figure class="flex flex-col items-center justify-center p-8 text-center bg-white border-b border-gray-200 md:rounded-es-lg md:border-b-0 md:border-e dark:bg-gray-800 dark:border-gray-700">
                    <blockquote class="max-w-2xl mx-auto mb-4 text-black lg:mb-8 dark:text-black">
                        <h3 class="text-lg font-semibold text-black dark:text-white">Abonnements</h3>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-black dark:text-black">
                                <thead class="text-xs text-black uppercase bg-gray-50 dark:bg-gray-700 dark:text-black">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Désigniation
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Début
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Fin
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            N°Série
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($abonnements as $abonnement)
                                    @if($abonnement->lignes && $abonnement->lignes->count() > 0)
                                    @foreach ($abonnement->lignes as $ligne)
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-black break-words whitespace-normal dark:text-white">
                                            {{ $ligne->AL_Design }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($abonnement->AB_Debut)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($abonnement->AB_Fin)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $ligne->N_de_Srie }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </blockquote>
                </figure>
                <figure class="flex flex-col items-center justify-center p-8 text-center bg-white border-gray-200 rounded-b-lg md:rounded-se-lg dark:bg-gray-800 dark:border-gray-700">
                    <blockquote class="max-w-2xl mx-auto mb-4 text-black lg:mb-8 dark:text-black">
                        <h3 class="text-lg font-semibold text-black dark:text-white">Commercial Agréé</h3>
                        <p class="my-4">
                            @if (isset($client->collaborateur))
                                {{ $client->collaborateur->CO_Nom }} {{ $client->collaborateur->CO_Prenom }}
                            @else
                                Aucun commercial
                            @endif
                        </p>
                    </blockquote>
                </figure>
            </div>
        </div>
        <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="about" role="tabpanel" aria-labelledby="about-tab">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-2xl font-extrabold tracking-tight text-black dark:text-white">
                    Liste des contacts de {{ $client->CT_Num }}
                </h2>
                <a href="{{ route('create.contact', ['id_client' => $client->CT_Num]) }}"
                   class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5 text-center">
                    Nouveau contact
                </a>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-black dark:text-black">
                    <thead class="text-xs text-black uppercase bg-gray-50 dark:bg-gray-700 dark:text-black">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nom
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Prénom
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Fonction
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Téléphone
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Portable
                            </th>
                            <th scope="col" class="px-6 py-3">
                                E-Mail
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Action</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap dark:text-white">
                                {{ $contact->cbMarq }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $contact->CT_Nom }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $contact->CT_Prenom }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $contact->CT_Fonction }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $contact->CT_Telephone }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $contact->CT_TelPortable }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $contact->CT_EMail }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('edit.contact', ['id_contact' => $contact->cbMarq]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="faq" role="tabpanel" aria-labelledby="faq-tab">
            <h2 class="mb-5 text-2xl font-extrabold tracking-tight text-black dark:text-white">Données internes du client {{ $client->CT_Num }}</h2>

        </div>
    </div>
</div>

@endsection
