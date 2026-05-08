@extends('layouts.app')

@section('title', 'Gestion des livres')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2">Gestion des livres</h1>
        </div>
        <div class="col-md-4 text-end">
            @if(auth()->user()->role_id >= 2)
            <a href="{{ route('livres.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter un livre
            </a>
            @endif
        </div>
    </div>

    <!-- Barre de recherche et filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('livres.index') }}" class="row g-3">
                        <div class="col-md-5">
                            <label for="search" class="form-label">
                                <i class="fas fa-search me-1"></i>Rechercher
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request()->get('search') }}"
                                   placeholder="Titre, auteur ou éditeur...">
                        </div>
                        <div class="col-md-4">
                            <label for="categorie" class="form-label">
                                <i class="fas fa-tag me-1"></i>Catégorie
                            </label>
                            <select class="form-select" id="categorie" name="categorie">
                                <option value="">Toutes les catégories</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->nom }}" 
                                            {{ request()->get('categorie') == $categorie->nom ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <div class="btn-group w-100">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-1"></i>Filtrer
                                </button>
                                <a href="{{ route('livres.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Réinitialiser
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($livres as $livre)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($livre->photo)
                    <img src="{{ asset('storage/' . $livre->photo) }}" class="card-img-top" alt="{{ $livre->titre }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-book fa-3x text-muted"></i>
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $livre->titre }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $livre->auteur }}</h6>

                    @if($livre->categorie)
                        <span class="badge bg-secondary mb-2">{{ $livre->categorie }}</span>
                    @endif

                    <p class="card-text flex-grow-1">
                        @if($livre->description)
                            {{ Str::limit($livre->description, 100) }}
                        @else
                            <em class="text-muted">Aucune description</em>
                        @endif
                    </p>

                    <div class="mt-auto">
                        <div class="row text-center mb-2">
                            <div class="col-6">
                                <small class="text-muted">Disponible</small>
                                <div class="fw-bold">{{ $livre->quantite_disponible }}/{{ $livre->quantite }}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Empruntés</small>
                                <div class="fw-bold">{{ $livre->empruntsCourants->count() }}</div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('livres.show', $livre) }}" class="btn btn-outline-primary btn-sm">
                                Voir
                            </a>
                            @if(auth()->user()->role_id >= 2)
                            <a href="{{ route('livres.edit', $livre) }}" class="btn btn-outline-secondary btn-sm">
                                Modifier
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($livres->hasPages())
    <div class="d-flex justify-content-center">
        {{ $livres->links() }}
    </div>
    @endif

    @if($livres->isEmpty())
    <div class="text-center py-5">
        <i class="fas fa-book fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">Aucun livre dans la bibliothèque</h4>
        <p class="text-muted">Commencez par ajouter votre premier livre.</p>
        <a href="{{ route('livres.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un livre
        </a>
    </div>
    @endif
</div>
@endsection