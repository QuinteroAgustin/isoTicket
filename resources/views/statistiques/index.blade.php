@extends('layouts.app')
@section('title', 'Statistiques')
@section('content')

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Statistiques et Rapports</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Section Statistiques Techniciens -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-blue-600">Statistiques des Techniciens</h2>
            <form action="{{ route('statistiques.export.techniciens') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="date_debut_tech" class="block text-sm font-medium text-gray-700">Date de début</label>
                        <input type="date" id="date_debut_tech" name="date_debut" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="date_fin_tech" class="block text-sm font-medium text-gray-700">Date de fin</label>
                        <input type="date" id="date_fin_tech" name="date_fin" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Exporter les statistiques techniciens
                </button>
            </form>
        </div>

        <!-- Section Statistiques Clients -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-blue-600">Statistiques des Clients</h2>
            <form action="{{ route('statistiques.export.clients') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="date_debut_client" class="block text-sm font-medium text-gray-700">Date de début</label>
                        <input type="date" id="date_debut_client" name="date_debut" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="date_fin_client" class="block text-sm font-medium text-gray-700">Date de fin</label>
                        <input type="date" id="date_fin_client" name="date_fin" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label for="type_rapport" class="block text-sm font-medium text-gray-700">Type de rapport</label>
                    <select id="type_rapport" name="type_rapport" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="temps_resolution">Temps de résolution moyen par client</option>
                        <option value="clients_frequents">Clients les plus fréquents</option>
                        <option value="tickets_par_service">Moyenne tickets par client et service</option>
                    </select>
                </div>
                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                    Exporter les statistiques clients
                </button>
            </form>
        </div>
    </div>
</div>

@endsection