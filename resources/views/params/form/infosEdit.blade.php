@extends('layouts.app')

@section('title', 'Modifier une information')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Modifier une information</h1>
        </div>

        <form action="{{ route('params.infos.update', $info->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="libelle" class="block text-sm font-medium text-gray-700">Libellé</label>
                    <input type="text" name="libelle" id="libelle" value="{{ old('libelle', $info->libelle) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <input type="text" name="description" id="description" value="{{ old('description', $info->description) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700">Icône (SVG)</label>
                    <textarea name="icon" id="icon" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('icon', $info->icon) }}</textarea>
                </div>

                <div>
                    <label for="ordre" class="block text-sm font-medium text-gray-700">Ordre</label>
                    <input type="number" name="ordre" id="ordre" value="{{ old('ordre', $info->ordre) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('params.infos.index') }}" 
                   class="bg-gray-200 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Annuler
                </a>
                <button type="submit"
                        class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection