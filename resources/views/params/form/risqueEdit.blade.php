@extends('layouts.app')

@section('title', 'Edition de risque')

@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 p-6">
                    <h2 class="text-lg font-bold mb-4">Modifier du risque</h2>
                    <form action="{{ route('params.risque.update', ['id' => $risque->id_risque]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="libelle" class="block text-sm font-medium text-gray-700">Libellé</label>
                            <input type="text" name="libelle" id="libelle" value="{{ $risque->libelle }}" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>
                            <input type="text" name="icon" id="icon" value="{{ $risque->icon }}" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="fond" class="block text-sm font-medium text-gray-700">Fond</label>
                            <input type="text" name="fond" id="fond" value="{{ $risque->fond }}" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="id_impact" class="block text-sm font-medium text-gray-700">Impact</label>
                            <select name="id_impact" id="id_impact" class="px-4 py-2 border rounded-md">
                                @foreach ($impacts as $impact)
                                    <option value="{{ $impact->id_impact }}" {{ $risque->id_impact == $impact->id_impact ? 'selected' : '' }}>{{ $impact->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="id_priorite" class="block text-sm font-medium text-gray-700">Priorite</label>
                            <select name="id_priorite" id="id_priorite" class="px-4 py-2 border rounded-md">
                                @foreach ($priorites as $priorite)
                                    <option value="{{ $priorite->id_priorite }}" {{ $risque->id_priorite == $priorite->id_priorite ? 'selected' : '' }}>{{ $priorite->libelle }}</option>
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
