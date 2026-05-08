<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Livre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LivreController extends Controller
{
    /**
     * Afficher la liste des livres
     */
    public function index()
    {
        $livres = Livre::with('empruntsCourants')->paginate(12);

        return view('livres.index', compact('livres'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $categories = Categorie::orderBy('nom')->get();
        return view('livres.create', compact('categories'));
    }

    /**
     * Enregistrer un nouveau livre
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'categorie' => 'nullable|string|max:100|exists:categories,nom',
            'date_publication' => 'nullable|date',
            'quantite' => 'required|integer|min:1',
            'resume' => 'nullable|string',
            'editeur' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $validated['quantite_disponible'] = $validated['quantite'];

        // Gestion de l'upload d'image
        if ($request->hasFile('photo')) {
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('public/livres', $imageName);
            $validated['photo'] = 'livres/' . $imageName;
        }

        Livre::create($validated);

        return redirect()->route('livres.index')->with('success', 'Livre ajouté avec succès !');
    }

    /**
     * Afficher un livre
     */
    public function show(Livre $livre)
    {
        $livre->load(['emprunts' => function($query) {
            $query->where('statut', 'en_cours')->with('user');
        }]);

        return view('livres.show', compact('livre'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Livre $livre)
    {
        $categories = Categorie::orderBy('nom')->get();
        return view('livres.edit', compact('livre', 'categories'));
    }

    /**
     * Mettre à jour un livre
     */
    public function update(Request $request, Livre $livre)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'categorie' => 'nullable|string|max:100|exists:categories,nom',
            'date_publication' => 'nullable|date',
            'quantite' => 'required|integer|min:1',
            'resume' => 'nullable|string',
            'editeur' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ajuster la quantité disponible si nécessaire
        $difference = $validated['quantite'] - $livre->quantite;
        $validated['quantite_disponible'] = $livre->quantite_disponible + $difference;

        // Gestion de l'upload d'image
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne image si elle existe
            if ($livre->photo && Storage::exists('public/' . $livre->photo)) {
                Storage::delete('public/' . $livre->photo);
            }

            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('public/livres', $imageName);
            $validated['photo'] = 'livres/' . $imageName;
        }

        $livre->update($validated);

        return redirect()->route('livres.index')->with('success', 'Livre modifié avec succès !');
    }

    /**
     * Supprimer un livre
     */
    public function destroy(Livre $livre)
    {
        // Vérifier s'il y a des emprunts actifs
        if ($livre->empruntsCourants()->exists()) {
            return back()->with('error', 'Impossible de supprimer un livre en cours d\'emprunt.');
        }

        // Supprimer l'image associée si elle existe
        if ($livre->photo && Storage::exists('public/' . $livre->photo)) {
            Storage::delete('public/' . $livre->photo);
        }

        $livre->delete();

        return redirect()->route('livres.index')->with('success', 'Livre supprimé avec succès !');
    }
}