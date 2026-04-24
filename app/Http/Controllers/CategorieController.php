<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user || $user->role_id < 2) {
            abort(403);
        }

        $categories = Categorie::query()
            ->withCount('livres')
            ->orderBy('nom')
            ->get();

        return view('dashboard.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user || $user->role_id < 2) {
            abort(403);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:100|unique:categories,nom',
        ]);

        Categorie::create($validated);

        return redirect()->route('categories')->with('success', 'Catégorie ajoutée avec succès.');
    }

    public function update(Request $request, Categorie $categorie)
    {
        $user = auth()->user();
        if (!$user || $user->role_id < 2) {
            abort(403);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:100|unique:categories,nom,' . $categorie->id,
        ]);

        $ancienNom = $categorie->nom;
        $nouveauNom = $validated['nom'];

        $categorie->update($validated);

        // Garder la cohérence des livres existants qui stockent le nom de catégorie
        \App\Models\Livre::where('categorie', $ancienNom)->update(['categorie' => $nouveauNom]);

        return redirect()->route('categories')->with('success', 'Catégorie modifiée avec succès.');
    }

    public function destroy(Categorie $categorie)
    {
        $user = auth()->user();
        if (!$user || $user->role_id < 2) {
            abort(403);
        }

        // Retirer la catégorie des livres liés avant suppression
        \App\Models\Livre::where('categorie', $categorie->nom)->update(['categorie' => null]);
        $categorie->delete();

        return redirect()->route('categories')->with('success', 'Catégorie supprimée avec succès.');
    }
}
