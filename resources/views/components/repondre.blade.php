<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<style>
    /* Custom CSS for Summernote lists */
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
</style>

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
            <form id="newFormReponse" action="{{ route('ticket.newMessage', ['id' => $ticket->id_ticket]) }}" method="POST">
                @csrf
                <div class="p-4 md:p-5 space-y-4">
                    <div class="flex flex-col lg:flex-row items-start lg:items-center"> <!-- Utilisation de flex-col pour une disposition en colonne sur mobile et flex-row pour une disposition en ligne sur desktop -->
                        <textarea id="message" name="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Écrire une réponse ..."></textarea>

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg mb-2 lg:mb-0 lg:mr-2" id="newSubmitReponse">Envoyer</button> <!-- mb-2 pour une marge en bas sur mobile, lg:mb-0 pour aucune marge en bas sur desktop, lg:mr-2 pour une marge à droite sur desktop -->
                    <div class="border border-gray-200 rounded dark:border-gray-700 flex px-4 py-2">
                        <input id="afficher" type="checkbox" value="1" name="afficher" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="afficher" class="text-sm font-medium text-gray-900 dark:text-gray-300 ml-2">Afficher</label> <!-- ml-2 pour une marge à gauche -->
                    </div>
                    <div class="max-w-[8rem] rounded dark:border-gray-700 flex px-4 py-2">
                        <input type="time" id="time_response" name="duree" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="00:00" {{ $disabled }} />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
<script>
    document.getElementById('newFormReponse').addEventListener('submit', function(event) {
        // Désactivez le bouton de soumission
        document.getElementById('newSubmitReponse').disabled = true;
    });
</script>
<script>
    $(document).ready(function() {
        $('#message').summernote({
            placeholder: 'Réponse ...',
            tabsize: 2,
            height: 400,
            width: 600,
            toolbar: [
              ['font', ['bold', 'underline', 'clear']],
              ['color', ['color']],
              ['table', ['table']],
              ['view', ['codeview']]
            ],
            callbacks: {
                onInit: function() {
                    // Autoriser les balises <u>, <td>, <li> et les styles <h1> dans Summernote
                    $('.note-editable').find('*').each(function() {
                        if (this.nodeName.toLowerCase() === 'u' || this.nodeName.toLowerCase() === 'td' || this.nodeName.toLowerCase() === 'li') {
                            $(this).addClass('note-editable');
                        }
                    });
                }
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formulaire = document.getElementById('newFormReponse');

        formulaire.addEventListener('submit', function(event) {
            // Annuler la soumission par défaut du formulaire
            event.preventDefault();

            // Réactiver le bouton de soumission au début pour chaque tentative
            document.getElementById('newSubmitReponse').disabled = false;

            // Vérifier ici si tous les champs sont valides
            const validationMessage = validateForm();

            if (validationMessage === '') {
                // Désactivez le bouton de soumission seulement si la validation passe
                document.getElementById('newSubmitReponse').disabled = true;
                // Soumettre le formulaire
                formulaire.submit();
            } else {
                // Afficher le message d'erreur à l'utilisateur
                alert(validationMessage);
                // Le bouton reste activé pour permettre une nouvelle tentative
            }
        });

        function validateForm() {
            // Vérifier ici chaque champ du formulaire
            const timeSaisi = document.getElementById('time_response').value.trim();
            const reponse = document.getElementById('message').value.trim();

            // Initialiser un message d'erreur vide
            let errorMessage = '';

            // Exemple de validation simple (vérifie que les champs ne sont pas vides)
            if (timeSaisi === '' || timeSaisi === "00:00") {
                errorMessage += 'Il faut mettre une durée minimale.\n';
            }
            if (reponse === '') {
                errorMessage += 'Il faut mettre une réponse.\n';
            }

            return errorMessage; // Retourner le message d'erreur
        }
    });
</script>
