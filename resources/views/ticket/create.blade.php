@extends('layouts.app')
@section('title', 'Création')
@section('page_title', '')

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

    <!-- Your Page Content Here -->
    <h1 class="text-2xl font-semibold">Création d'un nouveau ticket</h1>
    <form action="{{ route('createPost') }}" method="POST">
        @csrf
        <div class="flex">
            <div class="flex-none w-30 h-full p-4 ml-1">
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
                        <option selected value="">Choix du statut...</option>
                        @foreach ($status as $statut)
                        @if($statut->id_statut != 4)
                        @if($statut->masquer != 1)
                        <option value="{{ $statut->id_statut }}">{{ $statut->libelle }}</option>
                        @endif
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700 mt-5">
                    <input id="bordered-checkbox-1" type="checkbox" value="1" name="cri" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="bordered-checkbox-1" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">CRI</label>
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

                <input class="w-full h-12 px-6 text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800 mt-5" type="submit" value="Créer">


            </div>
            <div class="grow h-full p-4">
                <label for="titre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titre du ticket</label>
                <div class="flex">
                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    <svg width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 6V19M6 6H18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <input type="text" id="titre" name="titre" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Problème connexion Sage">
                </div>
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description de la problèmatique</label>
                <textarea id="message" name="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ecrire la description du problème ..."></textarea>

            </div>
            <div class="flex-none w-30 h-full p-4">
                <label for="client" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Client</label>
                <div class="flex">
                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                    </svg>
                </span>
                <input type="text" id="client" name="client" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="isociel" autocomplete="off">
                </div>
                <div id="dropdown" class="absolute bg-white border border-gray-300 mt-1 rounded shadow-lg hidden dropdown-scroll"></div>

                <div class="max-w-sm mx-auto">
                    <label for="contact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact</label>
                    <select id="contact" name="contact" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Choix du contact...</option>
                    </select>
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


    </script>

@endsection
