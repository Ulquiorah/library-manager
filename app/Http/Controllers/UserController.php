<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('role')->orderBy('nom')->paginate(10);
        $roles = Role::all();
        
        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user's role.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role_id' => ['required', 'integer', 'exists:roles,id'],
        ]);

        // Empêcher la modification du rôle de l'utilisateur actuel vers un rôle inférieur
        if (auth()->id() === $user->id && $request->role_id < $user->role_id) {
            return back()->with('error', 'Vous ne pouvez pas rétrograder votre propre rôle.');
        }

        $user->update([
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Le rôle de l\'utilisateur a été mis à jour avec succès.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Empêcher la suppression de son propre compte
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        // Vérifier si l'utilisateur a des emprunts en cours
        if ($user->emprunts()->where('statut', 'en_cours')->exists()) {
            return back()->with('error', 'Cet utilisateur a des emprunts en cours et ne peut pas être supprimé.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'L\'utilisateur a été supprimé avec succès.');
    }

    /**
     * Update user role via AJAX for quick updates
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => ['required', 'integer', 'exists:roles,id'],
        ]);

        // Empêcher la modification du rôle de l'utilisateur actuel vers un rôle inférieur
        if (auth()->id() === $user->id && $request->role_id < $user->role_id) {
            return response()->json(['error' => 'Vous ne pouvez pas rétrograder votre propre rôle.'], 403);
        }

        $user->update([
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rôle mis à jour avec succès',
            'new_role' => $user->role->type
        ]);
    }
}
