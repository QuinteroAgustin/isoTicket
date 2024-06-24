@extends('layouts.app')
@section('title', 'Edition')
@section('page_title', 'Edition du ticket de '.$ticket->id_client)

@section('content')

<style>
    /* Ajoutez cette classe pour limiter la hauteur du dropdown et permettre le défilement */
    .dropdown-scroll {
        max-height: 200px; /* Limite à environ 5 éléments (ajustez si nécessaire) */
        overflow-y: auto;
    }
</style>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @php
        $bgColor = '';
        foreach ($risques as $risque) {
            if ($ticket->impact->id_impact == $risque->id_impact && $ticket->priorite->id_priorite == $risque->id_priorite) {
                $bgColor = $risque->fond;

                break; // Sortir de la boucle une fois la condition satisfaite
            }
        }
    @endphp
    <!-- Your Page Content Here -->
    <h1 class="text-2xl font-semibold">
        <div>
            <div class="{{ $bgColor }} p-2 border-2 rounded-lg border-gray-500">
                N° {{ $ticket->id_ticket }}, Titre : {{ $ticket->titre }}
            </div>
            <div class="flex justify-end">
                Crée le  {{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m H:i') }}
            </div>
        </div>
    </h1>
    <form action="{{ route('ticket.edit.post', ['id' => $ticket->id_ticket]) }}" method="POST">
        @csrf
        <div class="flex">
            <!-- Gauche -->
            <div class="flex-none w-30 h-full p-4 ml-1">

                <!-- etat du ticket icon -->
                <ol class="relative text-gray-500 border-s border-gray-200 dark:border-gray-700 dark:text-gray-400">
                    <li class="mb-10 ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                            <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                            </svg>
                        </span>
                        <h3 class="font-medium leading-tight">Choix du client</h3>
                        <p class="text-sm">Societe client</p>
                    </li>
                    <li class="mb-10 ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                            <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                            </svg>
                        </span>
                        <h3 class="font-medium leading-tight">Ticket créer</h3>
                        <p class="text-sm">Discussion en cours</p>
                    </li>
                    @if($ticket->cloture != 1)
                    <li class="mb-10 ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                            </svg>
                        </span>
                        <h3 class="font-medium leading-tight">En cours</h3>
                        <p class="text-sm">Traitement...</p>
                    </li>
                    <li class="ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z"/>
                            </svg>
                        </span>
                        <h3 class="font-medium leading-tight">Clôture</h3>
                        <p class="text-sm">Ticket cloturé</p>
                    </li>
                    @else
                    <li class="mb-10 ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                            <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                            </svg>
                        </span>
                        <h3 class="font-medium leading-tight">En cours</h3>
                        <p class="text-sm">Traitement...</p>
                    </li>
                    <li class="ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                            <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                            </svg>
                        </span>
                        <h3 class="font-medium leading-tight">Clôture</h3>
                        <p class="text-sm">Ticket cloturé</p>
                    </li>
                    @endif
                </ol>
                <!-- fin etat du ticket icon -->

                <!-- statut -->
                <div class="max-w-sm mx-auto">
                    <label for="statut" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Statut</label>
                    <select id="statut" name="statut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($status as $statut)
                        @if($statut->masquer != 1)
                        <option value="{{ $statut->id_statut }}" {{ ($ticket->id_statut==$statut->id_statut)?'selected':'' }}>{{ $statut->libelle }}</option>
                        @elseif($ticket->id_statut==$statut->id_statut)
                        <option value="{{ $statut->id_statut }}" {{ ($ticket->id_statut==$statut->id_statut)?'selected':'' }}>{{ $statut->libelle }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <!-- cri -->
                <div class="flex items-center ps-2 border border-gray-200 rounded dark:border-gray-700 mt-2">
                    <input id="bordered-checkbox-1" type="checkbox" value="1" {{ ($ticket->cri==1)?'checked':'' }} name="cri" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="bordered-checkbox-1" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">CRI</label>
                </div>

                <!-- duree -->
                <div class="max-w-[8rem]">
                    <label for="time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Durée</label>
                    <div class="relative">
                        <input type="time" id="time" name="duree" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ ($ticket->duree!= 0)? $ticket->formatted_duree :'00:00' }}" required />
                    </div>
                </div>

                <!-- btn enregister -->
                @if($ticket->cloture != 1)
                <input class="w-full h-8 px-6 text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800 mt-1" type="submit" value="Enregister">
                @endif
            </div>

            <!-- Centre -->
            <div class="grow h-full p-4">
                <div class="flex flex-col max-h-[65vh]">
                    <!-- Section de discussion -->
                    <div class="flex-1 overflow-y-auto p-4">
                        <ul>
                            @foreach ($ticket->lignes as $ligne)
                                @if ($ligne->type_user >= 1)
                                <div class="flex justify-end mb-4">
                                    <div class="w-full max-w-sm">
                                        <div class="flex justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $ligne->technicien->nom }} {{ $ligne->technicien->prenom }}</span>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($ligne->created_at)->format('d/m H:i') }}
                                            </span>
                                        </div>
                                        @if ($ligne->type_user == 2)
                                            <div class="p-6 bg-yellow-100 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                                <p class="font-normal text-gray-700 dark:text-gray-400">{{ $ligne->text }}</p>
                                            </div>
                                        @else
                                            <div class="p-6 bg-green-100 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                                <p class="font-normal text-gray-700 dark:text-gray-400">{{ $ligne->text }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @else
                                <div class="mb-4 w-full max-w-sm">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">({{ $ligne->ct_num }}) {{ $ligne->ct_nom }} {{ $ligne->ct_prenom }}</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($ligne->created_at)->format('d/m H:i') }}
                                        </span>
                                    </div>
                                    <div  class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ $ligne->text }}</p>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                    Toggle modal
                </button>
            </div>


            <!-- droite -->
            <div class="flex-none w-30 h-full p-4">
                <!-- client -->
                <label for="client" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Client</label>
                <div class="flex">
                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                    </svg>
                </span>
                <input type="text" id="client" name="client" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="isociel" value="{{ ($ticket->id_client != null)? $ticket->id_client :'' }}" autocomplete="off">
                </div>
                <div id="dropdown" class="absolute bg-white border border-gray-300 mt-1 rounded shadow-lg hidden dropdown-scroll"></div>


                <!-- contact -->
                @if(!empty($ticket->id_client))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var ctNum = "{{ $ticket->id_client }}";
                            loadContacts(ctNum);
                        });
                    </script>
                @endif
                <div class="max-w-sm mx-auto">
                    <label for="contact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact</label>
                    <select id="contact" name="contact" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="{{ $ticket->lignes->first()->id_contact }}">{{ $ticket->lignes->first()->ct_nom }} {{ $ticket->lignes->first()->ct_prenom }}</option>
                    </select>
                </div>

                <!-- technicien -->
                <div class="max-w-sm mx-auto">
                    <label for="technicien" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Technicien</label>
                    <select id="technicien" name="technicien" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Choix du technicien...</option>
                        @foreach ($techniciens as $technicien)
                        @if($technicien->masquer != 1)
                        <option value="{{ $technicien->id_technicien }}" {{ ($ticket->id_technicien==$technicien->id_technicien)?'selected':'' }}>{{ $technicien->nom }} {{ $technicien->prenom }}</option>
                        @elseif($ticket->id_technicien==$technicien->id_technicien)
                        <option value="{{ $technicien->id_technicien }}" {{ ($ticket->id_technicien==$technicien->id_technicien)?'selected':'' }}>{{ $technicien->nom }} {{ $technicien->prenom }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <!-- service -->
                <div class="max-w-sm mx-auto">
                    <label for="service" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Service</label>
                    <select id="service" name="service" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Choix du service...</option>
                        @foreach ($services as $service)
                        <option value="{{ $service->id_service }}" {{ ($ticket->id_service==$service->id_service)?'selected':'' }}>{{ $service->libelle }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- categorie -->
                <div class="max-w-sm mx-auto">
                    <label for="categorie" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categorie</label>
                    <select id="categorie" name="categorie" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Choix de la categorie...</option>

                    </select>
                </div>

                <!-- fonction -->
                <div class="max-w-sm mx-auto">
                    <label for="fonction" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fonction</label>
                    <select id="fonction" name="fonction" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Choix de la fonction...</option>

                    </select>
                </div>

                <!-- priorite -->
                <div class="max-w-sm mx-auto">
                    <label for="priorite" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Priorité</label>
                    <select id="priorite" name="priorite" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Choix de la priorite...</option>
                        @foreach ($priorites as $priorite)
                        <option value="{{ $priorite->id_priorite }}" {{ ($ticket->id_priorite==$priorite->id_priorite)?'selected':'' }}>{{ $priorite->libelle }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- impact -->
                <div class="max-w-sm mx-auto">
                    <label for="impact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Impact</label>
                    <select id="impact" name="impact" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Choix de l'impact...</option>
                        @foreach ($impacts as $impact)
                        <option value="{{ $impact->id_impact }}" {{ ($ticket->id_impact==$impact->id_impact)?'selected':'' }}>{{ $impact->libelle }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>


    <!-- Section d'entrée de réponse -->
    @if($ticket->cloture == 0)
    <div class="bg-gray-100">
        <form action="{{ route('ticket.newMessage', ['id' => $ticket->id_ticket]) }}" method="POST">
            @csrf
            <div class="flex flex-col lg:flex-row items-start lg:items-center"> <!-- Utilisation de flex-col pour une disposition en colonne sur mobile et flex-row pour une disposition en ligne sur desktop -->
                <textarea id="message" name="message" rows="1" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Écrire une réponse ..."></textarea>
                <div class="flex flex-row lg:flex-row items-start lg:items-center mt-4 lg:mt-0 lg:ml-4"> <!-- Utilisation de flex-col pour une disposition en colonne sur mobile et flex-row pour une disposition en ligne sur desktop -->
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg mb-2 lg:mb-0 lg:mr-2">Envoyer</button> <!-- mb-2 pour une marge en bas sur mobile, lg:mb-0 pour aucune marge en bas sur desktop, lg:mr-2 pour une marge à droite sur desktop -->
                    <div class="border border-gray-200 rounded dark:border-gray-700 flex px-4 py-2">
                        <input id="masquer" type="checkbox" value="1" name="masquer" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="masquer" class="text-sm font-medium text-gray-900 dark:text-gray-300 ml-2">Masquer</label> <!-- ml-2 pour une marge à gauche -->
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endif

    <!-- Main modal -->
    <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Static modal
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        With less than a month to go before the European Union enacts new consumer privacy laws for its citizens, companies around the world are updating their terms of service agreements to comply.
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on May 25 and is meant to ensure a common set of data rights in the European Union. It requires organizations to notify users as soon as possible of high-risk data breaches that could personally affect them.
                    </p>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="static-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
                    <button data-modal-hide="static-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.getElementById('client').addEventListener('input', function() {
            let search = this.value.trim();
            if (search.length > 0) {
                axios.get('{{ route("search.clients") }}', { params: { search: search } })
                    .then(response => {
                        let clients = response.data;
                        let dropdown = document.getElementById('dropdown');
                        dropdown.innerHTML = '';
                        if (clients.length > 0) {
                            clients.forEach(client => {
                                let div = document.createElement('div');
                                div.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-200');
                                div.textContent = `${client.CT_Num} - ${client.CT_Intitule}`;
                                div.addEventListener('click', function() {
                                    document.getElementById('client').value = client.CT_Num;
                                    loadContacts(client.CT_Num);// Charger les contacts pour ce client
                                    dropdown.classList.add('hidden');
                                });
                                dropdown.appendChild(div);
                            });
                            dropdown.classList.remove('hidden');
                        } else {
                            dropdown.classList.add('hidden');
                        }
                    });
            } else {
                document.getElementById('dropdown').classList.add('hidden');
            }
        });

        function loadContacts(clientId) {
            axios.get(`/create/client/${clientId}`)
                .then(response => {
                    let contacts = response.data;
                    let select = document.getElementById('contact');
                    select.innerHTML = '<option value="">Choix du contact...</option>'; // Réinitialiser le select

                    let cbMarq = "{{ $ticket->lignes->sortBy('created_at')->first()->id_contact }}";
                    contacts.forEach(contact => {
                        let option = document.createElement('option');
                        option.value = contact.cbMarq;
                        option.text = contact.CT_Nom + '-' + contact.CT_Prenom;
                        // Vérifier si c'est le premier contact
                        if (contact.cbMarq === cbMarq) {
                            option.selected = true; // Sélectionner l'option correspondante
                        }

                        select.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des contacts:', error);
                });
        }



        document.addEventListener('click', function(event) {
            let dropdown = document.getElementById('dropdown');
            if (!dropdown.contains(event.target) && event.target.id !== 'client') {
                dropdown.classList.add('hidden');
            }
        });

        // Attendre que le DOM soit chargé
        document.addEventListener('DOMContentLoaded', function() {
            // Sélectionner les éléments HTML
            const selectservice = document.getElementById('service');
            const selectcategorie = document.getElementById('categorie');
            const selectfonction = document.getElementById('fonction');
            const initialSelectedCategorieId = {{ $ticket->id_categorie ?? 'null' }};
            const initialSelectedFunctionId = {{ $ticket->id_fonction ?? 'null' }};


            // Fonction pour mettre à jour select2
            function selectCategorie(selectedServiceId) {
                // Réinitialiser categorie
                selectcategorie.innerHTML = '<option value="">Choix de la categorie...</option>';
                // Réinitialiser fonction
                selectfonction.innerHTML = '<option selected value="">Choix de la fonction...</option>';
                // Si aucune catégorie n'est sélectionnée, sortir de la fonction
                if (!selectedServiceId) {
                    return;
                }

                // Filtrer les fonctions basées sur la catégorie sélectionnée
                const filteredCategories = @json($categories->groupBy('id_service'));

                // Ajouter les options filtrées à select2
                filteredCategories[selectedServiceId].forEach(function(categorie) {
                    const option = document.createElement('option');
                    option.value = categorie.id_categorie;
                    option.textContent = categorie.libelle;
                    if (categorie.id_categorie === initialSelectedCategorieId) {
                        option.selected = true;
                    }
                    selectcategorie.appendChild(option);
                });
            }
            // Écouter les changements sur select1
            selectservice.addEventListener('change', function() {
                // Récupérer la valeur sélectionnée dans select1
                const selectedServiceId = selectservice.value;

                // Mettre à jour select2
                selectCategorie(selectedServiceId);
            });

            // Mise à jour initiale de select2 si une catégorie est déjà sélectionnée
            if (selectservice.value) {
                selectCategorie(selectservice.value);
            }

            // Fonction pour mettre à jour select2
            function selectFonction(selectedCategorieId) {
                // Réinitialiser categorie
                selectfonction.innerHTML = '<option value="">Choix de la categorie...</option>';
                // Si aucune catégorie n'est sélectionnée, sortir de la fonction
                if (!selectedCategorieId) {
                    return;
                }

                // Filtrer les fonctions basées sur la catégorie sélectionnée
                const filteredFonctions = @json($fonctions->groupBy('id_categorie'));

                // Ajouter les options filtrées à select2
                filteredFonctions[selectedCategorieId].forEach(function(fonction) {
                    const option = document.createElement('option');
                    option.value = fonction.id_fonction;
                    option.textContent = fonction.libelle;
                    if (fonction.id_fonction === initialSelectedFunctionId) {
                        option.selected = true;
                    }
                    selectfonction.appendChild(option);
                });
            }
            // Écouter les changements sur select1
            selectcategorie.addEventListener('change', function() {
                // Récupérer la valeur sélectionnée dans select1
                const selectedCategorieId = selectcategorie.value;

                // Mettre à jour select2
                selectFonction(selectedCategorieId);
            });

            // Mise à jour initiale de select2 si une catégorie est déjà sélectionnée
            if (selectcategorie.value) {
                selectFonction(selectcategorie.value);
            }
        });

    </script>

@endsection
