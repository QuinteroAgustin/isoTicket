@extends('layouts.app')
@section('title', 'Création')
@section('page_title', '')

@section('content')

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>


<style>
    /* Custom CSS for Summernote lists */
    .note-editable { background-color: white; color: black; }
    .note-editor .note-editable ul,
    .note-editor .note-editable ol {
        margin-left: 20px; /* Adjust the margin as needed */
        padding-left: 20px; /* Ensure padding is applied */
    }

    .note-editor .note-editable ul {
        list-style-type: disc; /* Adjust list style for unordered lists */
    }

    .note-editor .note-editable ol {
        list-style-type: decimal; /* Adjust list style for ordered lists */
    }

    .note-editor .note-editable li {
        margin-bottom: 5px; /* Adjust the margin between list items */
    }

    /* Custom CSS for Summernote headings */
    .note-editor .note-editable h1,
    .note-editor .note-editable h2,
    .note-editor .note-editable h3,
    .note-editor .note-editable h4,
    .note-editor .note-editable h5,
    .note-editor .note-editable h6 {
        margin: 10px 0; /* Adjust the margin for headings */
        font-weight: bold; /* Ensure headings are bold */
    }

    /* Custom CSS for Summernote styles */
    .note-editor .note-editable strong {
        font-weight: bold; /* Ensure strong text is bold */
    }

    .note-editor .note-editable em {
        font-style: italic; /* Ensure emphasized text is italic */
    }

    .note-editor .note-editable u {
        text-decoration: underline; /* Ensure underlined text is underlined */
    }


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
    <!-- Your Page Content Here -->
    <h1 class="text-2xl font-semibold">Création d'un nouveau ticket</h1>
    <form id="create" action="{{ route('createPost') }}" method="POST">
        @csrf
        <div class="flex">

            <!-- Gauche -->
            <div class="flex-none w-30 h-full p-4 ml-1">
                <ol class="relative text-gray-500 border-s border-gray-200 dark:border-gray-700 dark:text-gray-400">
                    <li class="mb-10 ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                            <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                            </svg>
                        </span>
                        <h3 class="font-medium leading-tight">Choix du client</h3>
                    </li>
                    <li class="mb-10 ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/>
                            </svg>
                        </span>
                        <h3 class="font-medium leading-tight">Ticket créer</h3>
                        <p class="text-sm">Discussion en cours</p>
                    </li>
                    <li class="mb-10 ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                            </svg>
                        </span>
                        <h3 class="font-medium leading-tight">Récapitulatif</h3>
                        <p class="text-sm">Sommaire</p>
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
                </ol>

                <div class="max-w-sm mx-auto my-5">
                    <label for="statut" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Statut</label>
                    <select id="statut" name="statut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <!-- <option selected value="">Choix du statut...</option> -->
                        @foreach ($status as $statut)
                        @if($statut->id_statut != 4)
                        @if($statut->masquer != 1)
                        <option value="{{ $statut->id_statut }}">{{ $statut->libelle }}</option>
                        @endif
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="max-w-[8rem] mt-5">
                    <label for="time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Durée</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <input type="time" id="time" name="duree" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="00:00" required />
                    </div>
                </div>

                <input class="w-full h-12 px-6 text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800 mt-5" type="submit" value="Créer" id="submit-button">
            </div>


            <!-- centre -->
            <div class="grow h-full p-4">
                <label for="titre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titre du ticket</label>
                <div class="flex">
                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    <svg width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 6V19M6 6H18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <input type="text" id="titre" name="titre" class="rounded-none rounded-e-lg bg-white border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Problème connexion Sage">
                </div>
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description de la problèmatique</label>
                <textarea class="max-w-96 bg-white" id="message" name="message" rows="10" placeholder="Ecrire la description du problème ..."></textarea>
            </div>

            <!-- droite -->
            <div class="flex-none w-30 h-full p-4">
                <div class="max-w-sm mx-auto">
                    <label for="client" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Client</label>
                    <div class="flex">
                        <button data-modal-target="tabSociete" data-modal-toggle="tabSociete" class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600" type="button">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 7H7M6 10H7M11 10H12M11 13H12M6 13H7M11 7H12M7 21V18C7 16.8954 7.89543 16 9 16C10.1046 16 11 16.8954 11 18V21H7ZM7 21H3V4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H13.4C13.9601 3 14.2401 3 14.454 3.10899C14.6422 3.20487 14.7951 3.35785 14.891 3.54601C15 3.75992 15 4.03995 15 4.6V9M19.7 13.5C19.7 14.3284 19.0284 15 18.2 15C17.3716 15 16.7 14.3284 16.7 13.5C16.7 12.6716 17.3716 12 18.2 12C19.0284 12 19.7 12.6716 19.7 13.5ZM21.5 21V20.5C21.5 19.1193 20.3807 18 19 18H17.5C16.1193 18 15 19.1193 15 20.5V21H21.5Z" stroke="#4b5563" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <input type="text" id="client" name="client" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="isociel" autocomplete="off">
                    </div>
                    <div id="dropdown" class="absolute bg-white border border-gray-300 mt-1 rounded shadow-lg hidden dropdown-scroll"></div>
                </div>

                <div class="max-w-sm mx-auto">
                    <label for="contact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact</label>
                    <div class="flex">
                        <button data-modal-target="tabContact" data-modal-toggle="tabContact" class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600" type="button">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                            </svg>
                        </button>
                        <select id="contact" name="contact" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="">Choix du contact...</option>
                        </select>
                    </div>
                </div>

                <div class="max-w-sm mx-auto">
                    <label for="technicien" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Technicien</label>
                    <select id="technicien" name="technicien" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Choix du technicien...</option>
                        @foreach ($techniciens as $technicien)
                        @if($technicien->masquer != 1)
                        <option value="{{ $technicien->id_technicien }}">{{ $technicien->nom }} {{ $technicien->prenom }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="max-w-sm mx-auto">
                    <label for="service" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Service</label>
                    <select id="service" name="service" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Choix du service...</option>
                        @foreach ($services as $service)
                        @if($service->masquer != 1)
                        <option value="{{ $service->id_service }}">{{ $service->libelle }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="max-w-sm mx-auto">
                    <label for="categorie" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categorie</label>
                    <select id="categorie" name="categorie" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Choix de la categorie...</option>
                    </select>
                </div>

                <div class="max-w-sm mx-auto">
                    <label for="fonction" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fonction</label>
                    <select id="fonction" name="fonction" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Choix de la fonction...</option>
                    </select>
                </div>

                <div class="max-w-sm mx-auto">
                    <label for="priorite" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Priorité</label>
                    <select id="priorite" name="priorite" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Choix de la priorite...</option>
                        @foreach ($priorites as $priorite)
                        @if($priorite->masquer != 1)
                        <option value="{{ $priorite->id_priorite }}">{{ $priorite->libelle }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="max-w-sm mx-auto">
                    <label for="impact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Impact</label>
                    <select id="impact" name="impact" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Choix de l'impact...</option>
                        @foreach ($impacts as $impact)
                        @if($impact->masquer != 1)
                        <option value="{{ $impact->id_impact }}">{{ $impact->libelle }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>



            </div>
        </div>
    </form>

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
                                    fetchAndDisplayContacts(client.CT_Num);//generer le tableau des contacts
                                    fetchAndDisplayClient(client.CT_Num);//generer le tableau du client
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
                contacts.forEach(contact => {
                    let option = document.createElement('option');
                    option.value = contact.cbMarq;
                    option.text = contact.CT_Nom + '-' + contact.CT_Prenom;
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


        //Generer le tableau info contact
        const contactsTable = document.getElementById('contacts-table');

        function fetchAndDisplayContacts(clientId) {
            if (clientId) {
                axios.get(`/create/client/${clientId}/contacttableau`)
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
                            `;

                            contactsTable.appendChild(row);
                        });
                    })
                    .catch(error => {
                        console.error('Erreur lors de la récupération des contacts:', error);
                });
            }
        }

        //generer le tableau info cient
        const societeTable = document.getElementById('societe-table');

        function fetchAndDisplayClient(clientId) {
            if (clientId) {
                axios.get(`/create/client/${clientId}/societetableau`)
                    .then(response => {
                        const client = response.data.client;

                        // Sélectionner la carte modale
                        const modal = document.getElementById('tabSociete');

                        // Remplir la carte avec les données du client
                        modal.querySelector('h4').innerText = `ID: ${client.CT_Num}`;
                        modal.querySelector('p:nth-child(2)').innerHTML = `<strong>Nom:</strong> ${client.CT_Intitule}`;
                        modal.querySelector('p:nth-child(3)').innerHTML = `<strong>Téléphone:</strong> ${client.CT_Telephone || '-'}`;
                        modal.querySelector('p:nth-child(4)').innerHTML = `<strong>Télécopie:</strong> ${client.CT_Telecopie || '-'}`;
                        modal.querySelector('p:nth-child(5)').innerHTML = `<strong>Adresse:</strong> ${client.CT_Adresse}`;
                        modal.querySelector('p:nth-child(6)').innerHTML = `<strong>Ville:</strong> ${client.CT_Ville}`;
                        modal.querySelector('p:nth-child(7)').innerHTML = `<strong>Complément:</strong> ${client.CT_Complement || '-'}`;
                        modal.querySelector('p:nth-child(8)').innerHTML = `<strong>E-Mail:</strong> ${client.CT_EMail}`;

                        const collaborateur = client.collaborateur ? `${client.collaborateur.CO_Nom} ${client.collaborateur.CO_Prenom}` : 'Aucun commercial';
                        modal.querySelector('p:nth-child(9)').innerHTML = `<strong>Commercial Agréé:</strong> ${collaborateur}`;

                        // Ne pas afficher le modal ici
                    })
                    .catch(error => {
                        console.error('Erreur lors de la récupération du Client:', error);
                    });
            }
        }



        // Attendre que le DOM soit chargé
        document.addEventListener('DOMContentLoaded', function() {
            // Sélectionner les éléments HTML
            const selectservice = document.getElementById('service');
            const selectcategorie = document.getElementById('categorie');
            const selectfonction = document.getElementById('fonction');

            // Écouter les changements sur selectservice
            selectservice.addEventListener('change', function() {
                // Récupérer la valeur sélectionnée dans selectservice
                const selectedServiceId = selectservice.value;
                // Réinitialiser categorie
                selectcategorie.innerHTML = '<option selected value="">Choix de la categorie...</option>';
                // Réinitialiser fonction
                selectfonction.innerHTML = '<option selected value="">Choix de la fonction...</option>';
                // Si aucune catégorie n'est sélectionnée, sortir de la categorie
                if (!selectedServiceId) {
                    return;
                }


                // Filtrer les categories basées sur le service sélectionnée
                const filteredCategories = @json($categories->groupBy('id_service'));

                // Ajouter les options filtrées à categorie
                filteredCategories[selectedServiceId].forEach(function(categorie) {
                    if(categorie.masquer != 1){
                        const option = document.createElement('option');
                        option.value = categorie.id_categorie;
                        option.textContent = categorie.libelle;
                        selectcategorie.appendChild(option);
                    }

                });
            });

            // Écouter les changements sur selectservice
            selectcategorie.addEventListener('change', function() {
                // Récupérer la valeur sélectionnée dans selectservice
                const selectedCategorieId = selectcategorie.value;
                // Réinitialiser fonction
                selectfonction.innerHTML = '<option selected value="">Choix de la fonction...</option>';
                // Si aucune catégorie n'est sélectionnée, sortir de la fonction
                if (!selectedCategorieId) {
                    return;
                }
                // Filtrer les fonctions basées sur la catégorie sélectionnée
                const filteredFonctions = @json($fonctions->groupBy('id_categorie'));

                // Ajouter les options filtrées à categorie
                filteredFonctions[selectedCategorieId].forEach(function(fonction) {
                    if(fonction.masquer != 1){
                        const option = document.createElement('option');
                        option.value = fonction.id_fonction;
                        option.textContent = fonction.libelle;
                        selectfonction.appendChild(option);
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const formulaire = document.getElementById('create');

            formulaire.addEventListener('submit', function(event) {
                // Annuler la soumission par défaut du formulaire
                event.preventDefault();

                // Vérifier ici si tous les champs sont valides
                const validationMessage = validateForm();

                if (validationMessage === '') {
                    // Désactivez le bouton de soumission
                    document.getElementById('submit-button').disabled = true;
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
                const titre = document.getElementById('titre').value.trim();
                const message = document.getElementById('message').value.trim();
                const contact = document.getElementById('contact').value.trim();
                const technicien = document.getElementById('technicien').value.trim();
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
                if (titre === ''){
                    errorMessage += 'Le champ Titre est requis.\n';
                }
                if (message === ''){
                    errorMessage += 'Le champ Message est requis.\n';
                }
                if(contact === ''){
                    errorMessage += 'Le champ Contact est requis.\n';
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
    <script>
        $(document).ready(function() {
          $('#message').summernote({
            placeholder: 'Ecrire la description du problème ...',
            tabsize: 5,
            height: 300,
            toolbar: [
              ['font', ['bold', 'underline', 'clear']],
              ['color', ['color']],
              ['table', ['table']],
              ['insert', ['link', 'picture']],
              ['view', ['codeview']]
            ]
          });
        });
    </script>


@endsection
