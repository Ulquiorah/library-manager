<?php

namespace App\Http\Controllers;

use App\Models\Penalite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenaliteController extends Controller
{
    public function pay(Request $request, Penalite $penalite)
    {
        $user = Auth::user();

        if ($user->role_id < 2) {
            return redirect()->back()->with('error', 'Accès non autorisé.');
        }

        $penalite->update(['payee' => true]);

        return redirect()->back()->with('success', 'Pénalité marquée comme payée.');
    }
}