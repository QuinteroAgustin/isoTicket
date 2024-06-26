@extends('layouts.app')

@section('title', 'Edition de fonction')

@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 p-6">
                    <h2 class="text-lg font-bold mb-4">Modifier la fonction</h2>
                    <form action="{{ route('params.fonction.update', ['id' => $fonction->id_fonction]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="libelle" class="block text-sm font-medium text-gray-700">Libellé</label>
                            <input type="text" name="libelle" id="libelle" value="{{ $fonction->libelle }}" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="id_categorie" class="block text-sm font-medium text-gray-700">Categorie</label>
                            <select name="id_categorie" id="id_categorie" class="px-4 py-2 border rounded-md">
                                @foreach ($categories as $categorie)
                                    <option value="{{ $categorie->id_categorie }}" {{ $fonction->id_categorie == $categorie->id_categorie ? 'selected' : '' }}>{{ $categorie->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- masquer -->
                        <div class="flex items-center ps-2 mt-2">
                            <input id="bordered-checkbox-1" type="checkbox" value="1" {{ ($fonction->masquer==1)?'checked':'' }} name="masquer" class="w-4 h-4 text-blue-600 bg-gray-100 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="bordered-checkbox-1" class="w-full py-4 ms-2 text-sm font-medium text-gray-900">Masquer ?</label>
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
