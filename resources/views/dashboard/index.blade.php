@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2">Bienvenue, {{ auth()->user()->nom }} ! 👋</h1>
            <p class="text-muted">Rôle: <strong>{{ auth()->user()->role->type ?? 'Utilisateur' }}</strong></p>
        </div>
    </div>

    <div class="row">
        <!-- Statistiques -->
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="display-6">0</h2>
                    <p class="text-muted">Livres empruntés</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="display-6">0€</h2>
                    <p class="text-muted">Pénalités en attente</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="display-6">0</h2>
                    <p class="text-muted">Retours en retard</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="display-6">0</h2>
                    <p class="text-muted">Livres disponibles</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📖 Mes emprunts actuels</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted text-center py-4">Aucun emprunt pour le moment</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">⚠️ Pénalités</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted text-center py-4">Aucune pénalité</p>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role_id >= 2)
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">⚙️ Administration</h5>
                </div>
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <a href="#" class="btn btn-outline-primary">Gérer les livres</a>
                        <a href="#" class="btn btn-outline-primary">Voir les emprunts</a>
                        <a href="#" class="btn btn-outline-primary">Gérer les pénalités</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
