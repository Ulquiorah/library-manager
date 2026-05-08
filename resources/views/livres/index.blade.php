@extends('layouts.app')

@section('title', 'Toutes les livres')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/livres.css') }}" type="text/css">
@endpush

@section('content')
<div class="livres-container">
    <!-- Header -->
    <div class="livres-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-book"></i>
                Toutes les livres
            </h1>
            @if(auth()->user()->role_id >= 2)
                <a href="{{ route('livres.create') }}" class="add-book-btn">
                    <i class="fas fa-plus"></i>
                    Ajouter un livre
                </a>
            @endif
        </div>
    </div>

    <!-- Barre de recherche et filtres -->
    <div class="search-section">
        <form method="GET" action="{{ route('livres.index') }}" class="search-form">
            <div class="form-group">
                <label for="search" class="form-label">
                    <i class="fas fa-search"></i>
                    Rechercher
                </label>
                <input type="text" 
                       class="form-control" 
                       id="search" 
                       name="search" 
                       value="{{ request()->get('search') }}"
                       placeholder="Titre, auteur ou éditeur...">
            </div>
            <div class="form-group">
                <label for="categorie" class="form-label">
                    <i class="fas fa-tag"></i>
                    Catégorie
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
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i>
                    Filtrer
                </button>
                <a href="{{ route('livres.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Grid des livres -->
    <div class="livres-grid">
        @foreach($livres as $livre)
            <div class="livre-card">
                <div class="livre-image">
                    @if($livre->photo)
                        <img src="{{ asset('storage/' . $livre->photo) }}" alt="{{ $livre->titre }}">
                    @else
                        <div class="image-placeholder">
                            <i class="fas fa-book"></i>
                        </div>
                    @endif
                </div>
                <div class="livre-content">
                    <h3 class="livre-titre">{{ $livre->titre }}</h3>
                    <p class="livre-auteur">{{ $livre->auteur }}</p>
                    
                    @if($livre->categorie)
                        <span class="categorie-badge">{{ $livre->categorie }}</span>
                    @endif

                    <p class="livre-description">
                        @if($livre->description)
                            {{ Str::limit($livre->description, 150) }}
                        @else
                            <em class="text-muted">Aucune description</em>
                        @endif
                    </p>

                    <div class="stats-container">
                        <div class="stat-item">
                            <div class="stat-label">Disponible</div>
                            <div class="stat-value">{{ $livre->quantite_disponible }}/{{ $livre->quantite }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Empruntés</div>
                            <div class="stat-value">{{ $livre->empruntsCourants->count() }}</div>
                        </div>
                    </div>

                    <div class="livre-actions">
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
        @endforeach
    </div>

    <!-- Pagination -->
    @if($livres->hasPages())
    <div class="pagination-container">
        {{ $livres->links() }}
    </div>
    @endif

    <!-- Empty state -->
    @if($livres->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-book"></i>
        </div>
        <h3 class="empty-title">Aucun livre dans la bibliothèque</h3>
        <p class="empty-text">Commencez par ajouter votre premier livre.</p>
        @if(auth()->user()->role_id >= 2)
        <a href="{{ route('livres.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Ajouter un livre
        </a>
        @endif
    </div>
    @endif
</div>
@endsection