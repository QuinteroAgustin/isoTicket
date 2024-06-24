@extends('layouts.app')

@section('title', 'Edition du forfait')

@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 p-6">
                    <h2 class="text-lg font-bold mb-4">Modifier le forfait</h2>
                    <form action="{{ route('params.forfait.update', ['id' => $forfait->id_forfait]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="id_client">Code Client :</label>
                            <input type="text" name="id_client" value="{{ $forfait->id_client }}" placeholder="Code client (CT_Num)" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="created_at">Date de création :</label>
                            <input type="date" name="created_at" value="{{ \Carbon\Carbon::parse($forfait->created_at)->format('Y-m-d') }}" id="created_at" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="valid_to">Date de validité :</label>
                            <input type="date" name="valid_to" value="{{ \Carbon\Carbon::parse($forfait->valid_to)->format('Y-m-d') }}" id="valid_to" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="credit">Crédit :</label>
                            <input type="number" name="credit" value="{{ $forfait->credit }}" id="credit" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="id_type">Type :</label>
                            <select name="id_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach ($types as $type)
                                    <option value="{{ $type->id_type }}" {{ $forfait->id_type == $type->id_type ? 'selected' : '' }}>{{ $type->libelle }}</option>
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
