<div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="flex justify-between mb-3">
        <div class="flex items-center">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">Tickets Global</h5>
        </div>
        <h6>{{ $dateFormatted }}</h6>
    </div>
    <div class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3">
        <dl>
            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Ouverts</dt>
            <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-white">{{ $tickets->where('cloture', 0)->count() }}</dd>
        </dl>
    </div>

    <div class="grid grid-cols-2 py-3">
        <dl>
            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Ouvert aujourd'hui</dt>
            <dd class="leading-none text-xl font-bold text-green-500 dark:text-green-400">{{ $ticketsJour->count() }}</dd>
        </dl>
        <dl>
            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Clôturé aujourd'hui</dt>
            <dd class="leading-none text-xl font-bold text-red-600 dark:text-red-500">{{ $ticketsClotsJour->count() }}</dd>
        </dl>
    </div>
    <div id="more-details" class="border-gray-200 border-t dark:border-gray-600 pt-3 mt-3 space-y-2">
        <dl class="flex items-center justify-between">
            <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal">Ratio ouvert hier/aujourd'hui:</dt>
            @if($pourcentageDifference < 0)
            <dd class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-green-900 dark:text-green-300">
                {{ number_format($pourcentageDifference, 2) }}%
            </dd>
            @else
            <dd class="bg-red-100 text-red-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-green-900 dark:text-green-300">
                {{ number_format($pourcentageDifference, 2) }}%
            </dd>
            @endif
        </dl>
    </div>
</div>

<div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="flex justify-between mb-3">
        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">Tickets Status</h5>
    </div>
    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
        <div class="grid grid-cols-3 gap-3 mb-2">
            <dl class="bg-orange-50 dark:bg-gray-600 rounded-lg flex flex-col items-center justify-center h-[78px]">
                <dt class="w-8 h-8 rounded-full bg-orange-100 dark:bg-gray-500 text-orange-600 dark:text-orange-300 text-sm font-medium flex items-center justify-center mb-1">{{ $tickets->where('cloture', 0)->where('id_statut', 1)->count() }}</dt>
                <dd class="text-orange-600 dark:text-orange-300 text-sm font-medium">Nouveau</dd>
            </dl>
            <dl class="bg-teal-50 dark:bg-gray-600 rounded-lg flex flex-col items-center justify-center h-[78px]">
                <dt class="w-8 h-8 rounded-full bg-teal-100 dark:bg-gray-500 text-teal-600 dark:text-teal-300 text-sm font-medium flex items-center justify-center mb-1">{{ $tickets->where('cloture', 0)->where('id_statut', 3)->count() }}</dt>
                <dd class="text-teal-600 dark:text-teal-300 text-sm font-medium">En traitement</dd>
            </dl>
            <dl class="bg-blue-50 dark:bg-gray-600 rounded-lg flex flex-col items-center justify-center h-[78px]">
                <dt class="w-8 h-8 rounded-full bg-blue-100 dark:bg-gray-500 text-blue-600 dark:text-blue-300 text-sm font-medium flex items-center justify-center mb-1">{{ $ticketsClots->where('cloture', 1)->where('id_statut', 4)->count() }}</dt>
                <dd class="text-blue-600 dark:text-blue-300 text-sm font-medium">Cloturé</dd>
            </dl>
        </div>
    </div>
</div>
