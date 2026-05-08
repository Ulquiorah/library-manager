@extends('layouts.app')

@section('title', $livre->titre)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/livres-show.css') }}" type="text/css">
@endpush

@section('content')
<div class="livre-show-container">
    <!-- Header -->
    <div class="livre-header">
        <h1 class="livre-title">
            <i class="fas fa-book"></i>
            {{ $livre->titre }}
        </h1>
        <div class="livre-actions">
            @if(auth()->user()->role_id >= 2)
                <a href="{{ route('livres.edit', $livre) }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i>
                    Modifier
                </a>
            @endif
            <a href="{{ route('livres.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Retour
            </a>
        </div>
    </div>

    <!-- Section image -->
    <div class="livre-image-section">
        <div class="livre-image-container">
            @if($livre->photo)
                <img src="{{ asset('storage/' . $livre->photo) }}" alt="{{ $livre->titre }}" class="livre-image">
            @else
                <div class="image-placeholder">
                    <i class="fas fa-book"></i>
                </div>
            @endif
        </div>
    </div>

    <!-- Section informations -->
    <div class="livre-info-grid">
        <div class="livre-info-card">
            <div class="info-card-header">
                <h3 class="info-card-title">
                    <i class="fas fa-info-circle"></i>
                    Informations principales
                </h3>
            </div>
            <div class="info-card-content">
                <div class="info-item">
                    <span class="info-label">
                        <i class="fas fa-user-edit"></i>
                        Auteur
                    </span>
                    <span class="info-value">{{ $livre->auteur ?? 'Non spécifié' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">
                        <i class="fas fa-barcode"></i>
                        ISBN
                    </span>
                    <span class="info-value">{{ $livre->isbn ?? 'Non spécifié' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">
                        <i class="fas fa-tag"></i>
                        Catégorie
                    </span>
                    <span class="info-value">
                        @if($livre->categorie)
                            <span class="badge bg-secondary">{{ $livre->categorie }}</span>
                        @else
                            Non spécifiée
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">
                        <i class="fas fa-calendar"></i>
                        Date de publication
                    </span>
                    <span class="info-value">{{ $livre->date_publication ? $livre->date_publication->format('d/m/Y') : 'Non spécifiée' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">
                        <i class="fas fa-building"></i>
                        Éditeur
                    </span>
                    <span class="info-value">{{ $livre->editeur ?? 'Non spécifié' }}</span>
                </div>
            </div>
        </div>

        <div class="livre-info-card">
            <div class="info-card-header">
                <h3 class="info-card-title">
                    <i class="fas fa-align-left"></i>
                    Description
                </h3>
            </div>
            <div class="info-card-content">
                <div class="description-text">
                    @if($livre->description)
                        {{ $livre->description }}
                    @else
                        <em class="text-muted">Aucune description disponible</em>
                    @endif
                </div>
            </div>
        </div>

        <div class="livre-info-card">
            <div class="info-card-header">
                <h3 class="info-card-title">
                    <i class="fas fa-clipboard"></i>
                    Résumé
                </h3>
            </div>
            <div class="info-card-content">
                <div class="description-text">
                    @if($livre->resume)
                        {{ $livre->resume }}
                    @else
                        <em class="text-muted">Aucun résumé disponible</em>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Section statistiques -->
    <div class="livre-stats-section">
        <div class="stats-title">
            <i class="fas fa-chart-bar"></i>
            Statistiques du stock
        </div>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-number">{{ $livre->quantite_disponible }}</div>
                <div class="stat-label">Disponibles</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $livre->quantite }}</div>
                <div class="stat-label">Total</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $livre->empruntsCourants->count() }}</div>
                <div class="stat-label">Empruntés</div>
            </div>
        </div>
    </div>

    <!-- Section description détaillée -->
    @if($livre->description)
    <div class="livre-description-section">
        <div class="description-title">
            <i class="fas fa-file-alt"></i>
            Description complète
        </div>
        <div class="description-text">
            {{ $livre->description }}
        </div>
    </div>
    @endif

    <!-- Section résumé détaillé -->
    @if($livre->resume)
    <div class="livre-description-section">
        <div class="description-title">
            <i class="fas fa-clipboard"></i>
            Résumé complet
        </div>
        <div class="description-text">
            {{ $livre->resume }}
        </div>
    </div>
    @endif

    <!-- Section emprunts actuels -->
    <div class="livre-emprunts-section">
        <div class="emprunts-title">
            <i class="fas fa-hand-holding-heart"></i>
            Emprunts actuels
        </div>
        <div class="emprunts-list">
            @if($livre->emprunts->isEmpty())
                <div class="empty-emprunts">
                    <i class="fas fa-inbox"></i>
                    <h4>Aucun emprunt en cours</h4>
                    <p>Ce livre n'est actuellement emprunté par aucun utilisateur.</p>
                </div>
            @else
                @foreach($livre->emprunts as $emprunt)
                    <div class="emprunt-item">
                        <div class="emprunt-user">
                            <i class="fas fa-user"></i>
                            <strong>{{ $emprunt->user->nom }}</strong>
                        </div>
                        <div class="emprunt-date">
                            <i class="fas fa-calendar"></i>
                            Retour : {{ $emprunt->date_retour_prevue->format('d/m/Y') }}
                        </div>
                        <div class="emprunt-status">
                            @if($emprunt->date_retour_prevue->isPast())
                                <span class="status-en-retard">En retard</span>
                            @else
                                <span class="status-disponible">En cours</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Section actions -->
    <div class="livre-actions-section">
        <div class="actions-title">
            <i class="fas fa-cogs"></i>
            Actions disponibles
        </div><br>
        <div class="actions-grid">
            @if(auth()->user()->role_id >= 2)
                <form method="POST" action="{{ route('livres.destroy', $livre) }}"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn action-btn-danger">
                        <i class="fas fa-trash"></i>
                        Supprimer
                    </button>
                </form>
            @endif

            @if(auth()->user()->role_id < 2)
                @if($livre->quantite_disponible > 0)
                    <form action="{{ route('livres.emprunter', $livre) }}" method="POST">
                        @csrf
                        <button type="submit" class="action-btn action-btn-success">
                            <i class="fas fa-plus"></i>
                            Emprunter
                        </button>
                    </form>
                @else
                    <button class="action-btn action-btn-secondary" disabled>
                        <i class="fas fa-ban"></i>
                        Indisponible
                    </button>
                @endif
            @endif

            <a href="{{ route('livres.index') }}" class="action-btn action-btn-primary">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection