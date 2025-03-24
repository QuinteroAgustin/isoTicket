<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    public function index()
    {
        $apiKeys = ApiKey::all();
        return view('params.form.api', compact('apiKeys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expires_at' => 'nullable|date'
        ]);

        $apiKey = new ApiKey();
        $apiKey->name = $request->name;
        $apiKey->description = $request->description;
        $apiKey->key = Str::random(64);
        $apiKey->expires_at = $request->expires_at;
        $apiKey->created_by = session('technicien')->id_technicien;
        $apiKey->save();

        return redirect()->route('params.form.api')
            ->with('success', 'Clé API créée avec succès');
    }

    public function destroy($id)
    {
        $apiKey = ApiKey::findOrFail($id);
        $apiKey->delete();

        return redirect()->route('params.form.api')
            ->with('success', 'Clé API supprimée avec succès');
    }
}
