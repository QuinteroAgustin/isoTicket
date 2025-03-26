<?php

namespace App\Http\Controllers;

use App\Models\InfoUtile;
use Illuminate\Http\Request;

class InfoUtileController extends Controller
{
    public function index()
    {
        $infos = InfoUtile::orderBy('ordre')->get();
        return view('params.form.infos', compact('infos'));
    }

    public function edit($id)
    {
        $info = InfoUtile::findOrFail($id);
        return view('params.form.infosEdit', compact('info'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'ordre' => 'required|integer|min:0'
        ]);

        $info = InfoUtile::findOrFail($id);
        $info->update($request->all());

        return redirect()->route('params.infos.index')
            ->with('success', 'Information mise à jour avec succès');
    }

    public function toggleActive($id)
    {
        $info = InfoUtile::findOrFail($id);
        $info->active = !$info->active;
        $info->save();
    
        return redirect()->route('params.infos.index')
            ->with('success', 'Statut mis à jour avec succès');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'ordre' => 'required|integer|min:0'
        ]);

        InfoUtile::create([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'icon' => $request->icon,
            'ordre' => $request->ordre,
            'active' => true
        ]);

        return redirect()->route('params.infos.index')
            ->with('success', 'Information ajoutée avec succès');
    }

    public function destroy($id)
    {
        try {
            $info = InfoUtile::findOrFail($id);
            $info->delete();
    
            return redirect()->route('params.infos.index')
                ->with('success', 'Information supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->route('params.infos.index')
                ->with('error', 'Erreur lors de la suppression');
        }
    }
}
