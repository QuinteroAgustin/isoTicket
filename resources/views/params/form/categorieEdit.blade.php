@extends('layouts.app')

@section('title', 'Edition de categorie')

@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 p-6">
                    <h2 class="text-lg font-bold mb-4">Modifier la categorie</h2>
                    <form action="{{ route('params.categorie.update', ['id' => $categorie->id_categorie]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="libelle" class="block text-sm font-medium text-gray-700">Libellé</label>
                            <input type="text" name="libelle" id="libelle" value="{{ $categorie->libelle }}" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="id_service" class="block text-sm font-medium text-gray-700">Service</label>
                            <select name="id_service" id="id_service" class="px-4 py-2 border rounded-md">
                                @foreach ($services as $service)
                                    <option value="{{ $service->id_service }}" {{ $categorie->id_service == $service->id_service ? 'selected' : '' }}>{{ $service->libelle }}</option>
                                @endforeach
                            </select>
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
