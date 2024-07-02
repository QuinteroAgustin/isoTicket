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
