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
    /* Masquer le menu déroulant par défaut */
    #forfaits-dropdown {
        display: none;
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
        $disabled = '';
        if($ticket->cloture == 1){
            $disabled = 'disabled';
        }
    @endphp
    <!-- Your Page Content Here -->
    <h1 class="text-2xl font-semibold">
        <div>
            <div class="{{ $bgColor }} p-2 border-2 rounded-lg border-gray-500">
                N° {{ $ticket->id_ticket }}, {{ $ticket->titre }}
            </div>
            <div class="flex justify-end">
                Crée le  {{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m H:i') }}
            </div>
        </div>
    </h1>
    <form id="editTicket" action="{{ route('ticket.edit.post', ['id' => $ticket->id_ticket]) }}" method="POST">
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
                    <select id="statut" name="statut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" {{ $disabled }}>
                        @foreach ($status as $statut)
                        @if($statut->masquer != 1)
                        <option value="{{ $statut->id_statut }}" {{ ($ticket->id_statut==$statut->id_statut)?'selected':'' }}>{{ $statut->libelle }}</option>
                        @elseif($ticket->id_statut==$statut->id_statut)
                        <option value="{{ $statut->id_statut }}" {{ ($ticket->id_statut==$statut->id_statut)?'selected':'' }}>{{ $statut->libelle }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <!-- duree -->
                <div class="max-w-[8rem]">
                    <label for="time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Durée</label>
                    <div class="relative">
                        <input type="time" id="time" name="duree" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ ($ticket->duree!= 0)? $ticket->formatted_duree :'00:00' }}" {{ $disabled }} />
                    </div>
                </div>

                <!-- cri -->
                <div class="flex items-center ps-2 border border-gray-200 rounded dark:border-gray-700 mt-2">
                    <input id="cri" type="checkbox" value="1" {{ ($ticket->cri==1)?'checked':'' }} name="cri" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $disabled }}>
                    <label for="cri" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">CRI</label>
                </div>
                <div>
                    <!-- Menu déroulant pour les forfaits -->
                    <div class="max-w-sm mx-auto" id="forfaits-dropdown">
                        <label for="forfait" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Forfaits</label>
                        <select id="forfait" name="forfait" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  {{ $disabled }}>
                            <option selected value="">Choisir un forfait...</option>
                            @foreach ($forfaits as $forfait)
                                @if ($forfait->id_client == $ticket->id_client)
                                    <option {{ ($forfait->id_forfait == $ticket->id_forfait)? 'selected' : '' }} value="{{ $forfait->id_forfait }}">{{ $forfait->id_forfait }}-{{ $forfait->type->libelle }} ({{ $forfait->restant() }} crédit)</option>
                                @endif
                            @endforeach
                        </select>
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
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $ticket->id_client }}</span>
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
                @if($ticket->cloture == 0)
                <button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full mt-2" type="button">
                    Répondre
                </button>
                @endif
            </div>


            <!-- droite -->
            <div class="flex-none w-30 h-full p-4">
                <!-- client -->
                <div class="max-w-sm mx-auto">
                    <label for="client" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Client</label>
                    <div class="flex">
                        <button data-modal-target="tabSociete" data-modal-toggle="tabSociete" class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600" type="button">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 7H7M6 10H7M11 10H12M11 13H12M6 13H7M11 7H12M7 21V18C7 16.8954 7.89543 16 9 16C10.1046 16 11 16.8954 11 18V21H7ZM7 21H3V4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H13.4C13.9601 3 14.2401 3 14.454 3.10899C14.6422 3.20487 14.7951 3.35785 14.891 3.54601C15 3.75992 15 4.03995 15 4.6V9M19.7 13.5C19.7 14.3284 19.0284 15 18.2 15C17.3716 15 16.7 14.3284 16.7 13.5C16.7 12.6716 17.3716 12 18.2 12C19.0284 12 19.7 12.6716 19.7 13.5ZM21.5 21V20.5C21.5 19.1193 20.3807 18 19 18H17.5C16.1193 18 15 19.1193 15 20.5V21H21.5Z" stroke="#4b5563" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <input type="text" id="client" name="client" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="isociel" value="{{ ($ticket->id_client != null)? $ticket->id_client :'' }}" autocomplete="off" {{ $disabled }}>
                    </div>
                    <div id="dropdown" class="absolute bg-white border border-gray-300 mt-1 rounded shadow-lg hidden dropdown-scroll"></div>
                </div>


                <!-- contact -->
                @if(!empty($ticket->id_client))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var ctNum = "{{ $ticket->id_client }}";
                            loadContacts(ctNum);//charger les contacts
                            fetchAndDisplayContacts(ctNum);//charger le tableau de contact
                        });
                    </script>
                @endif

                <div class="max-w-sm mx-auto">
                    <label for="contact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact</label>
                    <div class="flex">
                        <button data-modal-target="tabContact" data-modal-toggle="tabContact" class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600" type="button">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                            </svg>
                        </button>
                        <select id="contact" name="contact" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="{{ $ticket->lignes->first()->id_contact }}">{{ $ticket->lignes->first()->ct_nom }} {{ $ticket->lignes->first()->ct_prenom }}</option>
                        </select>
                    </div>
                </div>

                <!-- technicien -->
                <div class="max-w-sm mx-auto">
                    <label for="technicien" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Technicien</label>
                    <select id="technicien" name="technicien" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" {{ $disabled }}>
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
                    <select id="service" name="service" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" {{ $disabled }}>
                        <option selected value="">Choix du service...</option>
                        @foreach ($services as $service)
                        <option value="{{ $service->id_service }}" {{ ($ticket->id_service==$service->id_service)?'selected':'' }}>{{ $service->libelle }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- categorie -->
                <div class="max-w-sm mx-auto">
                    <label for="categorie" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categorie</label>
                    <select id="categorie" name="categorie" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" {{ $disabled }}>
                        <option selected value="">Choix de la categorie...</option>

                    </select>
                </div>

                <!-- fonction -->
                <div class="max-w-sm mx-auto">
                    <label for="fonction" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fonction</label>
                    <select id="fonction" name="fonction" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" {{ $disabled }}>
                        <option selected value="">Choix de la fonction...</option>

                    </select>
                </div>

                <!-- priorite -->
                <div class="max-w-sm mx-auto">
                    <label for="priorite" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Priorité</label>
                    <select id="priorite" name="priorite" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" {{ $disabled }}>
                        <option selected value="">Choix de la priorite...</option>
                        @foreach ($priorites as $priorite)
                        <option value="{{ $priorite->id_priorite }}" {{ ($ticket->id_priorite==$priorite->id_priorite)?'selected':'' }}>{{ $priorite->libelle }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- impact -->
                <div class="max-w-sm mx-auto">
                    <label for="impact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Impact</label>
                    <select id="impact" name="impact" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" {{ $disabled }}>
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
        <!-- Main modal -->
        <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Répondre au ticket {{ $ticket->id_ticket }}
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Fermer</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form action="{{ route('ticket.newMessage', ['id' => $ticket->id_ticket]) }}" method="POST">
                        @csrf
                        <div class="p-4 md:p-5 space-y-4">
                            <div class="flex flex-col lg:flex-row items-start lg:items-center"> <!-- Utilisation de flex-col pour une disposition en colonne sur mobile et flex-row pour une disposition en ligne sur desktop -->
                                <textarea id="message" name="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Écrire une réponse ..."></textarea>

                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg mb-2 lg:mb-0 lg:mr-2">Envoyer</button> <!-- mb-2 pour une marge en bas sur mobile, lg:mb-0 pour aucune marge en bas sur desktop, lg:mr-2 pour une marge à droite sur desktop -->
                            <div class="border border-gray-200 rounded dark:border-gray-700 flex px-4 py-2">
                                <input id="masquer" type="checkbox" value="1" name="masquer" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="masquer" class="text-sm font-medium text-gray-900 dark:text-gray-300 ml-2">Masquer</label> <!-- ml-2 pour une marge à gauche -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <!-- Bouton pour ouvrir le modal -->
    <button data-modal-target="credit-insufficient-modal" data-modal-toggle="credit-insufficient-modal" class="hidden" id="modal-trigger"></button>

     <!-- popup forfait HTML -->
    <div  id="credit-insufficient-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Le client {{ $ticket->id_client }} n'a plus de crédit dans son forfait sélectionné.</h3>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Liste des forfaits du client</h2>
                    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-center">ID</th>
                                    <th class="py-3 px-6 text-left">Type</th>
                                    <th class="py-3 px-6 text-left">Crédit</th>
                                    <th class="py-3 px-6 text-left">Restant</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($forfaits as $forfait)
                                    @if ($forfait->id_client == $ticket->id_client && $forfait->masquer != 1)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-3 px-6 text-center">{{ $forfait->id_forfait }}</td>
                                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $forfait->type->libelle }}</td>
                                            <td class="py-3 px-6 text-left">{{ $forfait->credit }}</td>
                                            <td class="py-3 px-6 text-left">{{ $forfait->restant() }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                        Attention à la durée du ticket.
                    </div>
                    <button data-modal-hide="credit-insufficient-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Compris
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclure le composant des tab contact -->
    @include('components.contact')
    <!-- Inclure le composant des info societe -->
    @include('components.societe')

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
                                    fetchAndDisplayContacts(client.CT_Num);//charger le tableau de contact
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
                    console.error('Erreur lors du chargement des contacts');
                });
        }



        document.addEventListener('click', function(event) {
            let dropdown = document.getElementById('dropdown');
            if (!dropdown.contains(event.target) && event.target.id !== 'client') {
                dropdown.classList.add('hidden');
            }
        });

        const contactsTable = document.getElementById('contacts-table');

        function fetchAndDisplayContacts(clientId) {
            if (clientId) {
                console.log(clientId);
                axios.get(`/create/client/${clientId}/tableau`)
                    .then(response => {
                        const contacts = response.data.contacts;
                        contactsTable.innerHTML = ''; // Clear previous content

                        contacts.forEach(contact => {
                            const row = document.createElement('tr');
                            row.classList.add('border-b', 'border-gray-200', 'hover:bg-gray-100');

                            row.innerHTML = `
                                <td class="py-3 px-6 text-center">${contact.cbMarq}</td>
                                <td class="py-3 px-6 text-left">${contact.CT_Nom}</td>
                                <td class="py-3 px-6 text-left">${contact.CT_Prenom}</td>
                                <td class="py-3 px-6 text-left">${contact.CT_Fonction}</td>
                                <td class="py-3 px-6 text-left">${contact.CT_Telephone}</td>
                                <td class="py-3 px-6 text-left">${contact.CT_TelPortable}</td>
                                <td class="py-3 px-6 text-left">${contact.CT_EMail}</td>
                                <td class="py-3 px-6 text-left"></td>
                            `;

                            contactsTable.appendChild(row);
                        });
                    })
                    .catch(error => {
                        console.error('Erreur lors de la récupération des contacts:', error);
                    });
            }
        }

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

        // Fonction pour afficher/masquer le menu déroulant
        document.getElementById('cri').addEventListener('change', function () {
            var dropdown = document.getElementById('forfaits-dropdown');
            if (this.checked) {
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        });

        //check forfait restant
        document.addEventListener('DOMContentLoaded', (event) => {
            const criCheckbox = document.getElementById('cri');
            const forfaitsDropdown = document.getElementById('forfaits-dropdown');
            const selectElement = document.getElementById('forfait');
            const ticketDuree = document.getElementById('time');

            function showModal() {
                const modal = document.getElementById('credit-insufficient-modal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function hideModal() {
                const modal = document.getElementById('credit-insufficient-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            // Attacher l'événement de fermeture à tous les boutons de fermeture de modal
            document.querySelectorAll('[data-modal-hide]').forEach(button => {
                button.addEventListener('click', hideModal);
            });

            // Fonction pour convertir la durée en format HH:MM en minutes totales
            function convertDureeToMinutes(duree) {
                // Séparer les heures et les minutes en utilisant le séparateur ":"
                const [hours, minutes] = duree.split(':');

                // Convertir les heures et les minutes en nombres entiers
                const totalMinutes = (parseInt(hours, 10) * 60) + parseInt(minutes, 10);

                return totalMinutes;
            }

            // Fonction pour vérifier le crédit restant via une requête Axios
            function checkCredit() {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const forfaitId = selectedOption.value;

                if (forfaitId) {
                    axios.get(`/ticket/forfait/${forfaitId}/credit`)
                        .then(response => {
                            const remainingCredit = response.data.remainingCredit;
                            if (remainingCredit < 0 || remainingCredit - convertDureeToMinutes(ticketDuree.value) < 0) {
                                showModal();
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de la vérification du crédit');
                        });
                }
            }

            // Fonction pour initialiser l'affichage du dropdown en fonction de l'état de la case à cocher "CRI"
            function initializeDropdown() {
                if (criCheckbox.checked) {
                    forfaitsDropdown.style.display = 'block';
                } else {
                    forfaitsDropdown.style.display = 'none';
                }
            }

            // Initialiser l'affichage du dropdown au chargement de la page
            initializeDropdown();

            // Ajouter un écouteur d'événement à la case à cocher "CRI" pour afficher ou masquer le dropdown
            criCheckbox.addEventListener('change', initializeDropdown);

            // Vérifier le crédit lors du changement de sélection
            selectElement.addEventListener('change', checkCredit);

            // Vérifier le crédit lors du changement de la durée
            ticketDuree.addEventListener('input', checkCredit);

            // Vérifier le crédit au chargement si une option est déjà sélectionnée
            if (selectElement.value) {
                checkCredit();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const formulaire = document.getElementById('editTicket');

            formulaire.addEventListener('submit', function(event) {
                // Annuler la soumission par défaut du formulaire
                event.preventDefault();

                // Vérifier ici si tous les champs sont valides
                const validationMessage = validateForm();

                if (validationMessage === '') {
                    // Soumettre le formulaire si la validation passe
                    formulaire.submit();
                } else {
                    // Afficher le message d'erreur à l'utilisateur
                    alert(validationMessage);
                }
            });

            // Fonction pour convertir la durée en format HH:MM en minutes totales
            function convertDureeToMinutes(duree) {
                // Séparer les heures et les minutes en utilisant le séparateur ":"
                const [hours, minutes] = duree.split(':');

                // Convertir les heures et les minutes en nombres entiers
                const totalMinutes = (parseInt(hours, 10) * 60) + parseInt(minutes, 10);

                return totalMinutes;
            }

            function validateForm() {
                // Vérifier ici chaque champ du formulaire
                const client = document.getElementById('client').value.trim();
                const contact = document.getElementById('contact').value.trim();
                const technicien = document.getElementById('technicien').value.trim();
                const cri = document.getElementById('cri');
                const forfait = document.getElementById('forfait').value.trim();
                const time = document.getElementById('time').value.trim();
                const statut = document.getElementById('statut').value.trim();
                const service = document.getElementById('service').value.trim();
                const categorie = document.getElementById('categorie').value.trim();
                const fonction = document.getElementById('fonction').value.trim();
                const priorite = document.getElementById('priorite').value.trim();
                const impact = document.getElementById('impact').value.trim();

                // Initialiser un message d'erreur vide
                let errorMessage = '';

                // Exemple de validation simple (vérifie que les champs ne sont pas vides)
                if (client === ''){
                    errorMessage += 'Le champ Client est requis.\n';
                }
                if(contact === ''){
                    errorMessage += 'Le champ Contact est requis.\n';
                }
                if(technicien === '') {
                    errorMessage += 'Le champ Technicien est requis.\n';
                }

                if(cri.checked){
                    if(convertDureeToMinutes(time) < 1){
                        errorMessage += 'Une durée minimale est requise.\n';
                    }
                    if(forfait == ''){
                        errorMessage += 'Le choix du forfait est requis.\n';
                    }
                }

                if(statut == 4){
                    if(convertDureeToMinutes(time) < 1){
                        errorMessage += 'Une durée minimale est requise.\n';
                    }
                }
                if(statut === ''){
                    errorMessage += 'Le champ Statut est requis.\n';
                }
                if(service === ''){
                    errorMessage += 'Le champ Service est requis.\n';
                }
                if(categorie === ''){
                    errorMessage += 'Le champ Categorie est requis.\n';
                }
                if(fonction === ''){
                    errorMessage += 'Le champ Fonction est requis.\n';
                }
                if(priorite === ''){
                    errorMessage += 'Le champ Priorité est requis.\n';
                }
                if(impact === ''){
                    errorMessage += 'Le champ Impact est requis.\n';
                }

                return errorMessage; // Retourner le message d'erreur
            }
        });

    </script>

@endsection
