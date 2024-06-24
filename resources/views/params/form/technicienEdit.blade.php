@extends('layouts.app')

@section('title', 'Edition de \'un technicien')

@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 p-6">
                    <h2 class="text-lg font-bold mb-4">Modifier du technicien</h2>
                    <form action="{{ route('params.technicien.update', ['id' => $technicien->id_technicien]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">Nom :</label>
                            <input type="text" name="nom" id="nom" value="{{ $technicien->nom }}" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="prenom" class="block text-gray-700 text-sm font-bold mb-2">Prénom :</label>
                            <input type="text" name="prenom" id="prenom" value="{{ $technicien->prenom }}" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">E-Mail :</label>
                            <input type="text" name="email" id="email" value="{{ $technicien->email }}" class="px-4 py-2 border rounded-md" disabled>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe :</label>
                            <input type="password" name="password" id="password" placeholder="Mot de passe" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="id_role">Rôle :</label>
                            <select name="id_role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id_role }}" {{ $technicien->id_role == $role->id_role ? 'selected' : '' }}>{{ $role->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="id_service">Service :</label>
                            <select name="id_service" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach ($services as $service)
                                    <option value="{{ $service->id_service }}" {{ $technicien->id_service == $service->id_service ? 'selected' : '' }}>{{ $service->libelle }}</option>
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
