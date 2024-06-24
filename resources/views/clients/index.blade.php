@extends('layouts.app')
@section('title', 'Clients')
@section('page_title', 'Liste des clients')

@section('content')
    <!-- Your Page Content Here -->
    <h1 class="text-2xl font-semibold">Clients</h1>
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <!-- Form for Filtering -->
                <form id="filterForm" class="mb-4">
                    <div class="flex items-center">
                        <input type="text" id="code_client" name="code_client" placeholder="Code client" class="mr-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <input type="text" id="nom_client" name="nom_client" placeholder="Nom client" class="mr-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <input type="text" id="telephone" name="telephone" placeholder="Numéro de téléphone" class="mr-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <input type="text" id="ville" name="ville" placeholder="Ville" class="mr-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <input type="text" id="code_postal" name="code_postal" placeholder="Code postal" class="mr-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

                        <button type="button" id="filterButton" data-url="{{ $filterUrl }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Filtrer
                        </button>
                    </div>
                </form>
                <!-- Pagination Links -->
                <div class="mt-4 flex items-center justify-between">
                    <div class="hidden">
                        {{ $clients->appends(request()->query())->links() }}
                    </div>
                    <div class="flex items-center">
                        @if ($clients->previousPageUrl())
                            <a href="{{ $clients->previousPageUrl() }}" class="bg-gray-200 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l">
                                Précédent
                            </a>
                        @endif
                        @if ($clients->nextPageUrl())
                            <a href="{{ $clients->nextPageUrl() }}" class="bg-gray-200 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-r">
                                Suivant
                            </a>
                        @endif
                    </div>
                </div>
                <div class="bg-white shadow-md rounded my-6 overflow-x-auto overflow-y-auto max-h-[60vh]">
                    <!-- Tableau des clients -->
                    @include('clients.client_table')
                </div>
            </div>

        </div>
    </div>

    <script src="{{ asset('js/filter.js') }}" data-route="{{ route('clients.filter') }}"></script>
@endsection
