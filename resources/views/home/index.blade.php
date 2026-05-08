@extends('layouts.app')

@section('title', 'Accueil')
@section('main_class', 'py-0')
@section('footer_class', 'mt-0')

@section('content')
<div class="container-fluid home-layout px-0">
    <div class="row g-0 justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8 px-3 px-lg-4">
            <!-- En-tête -->
            <div class="row mb-4 justify-content-center">
                <div class="col-md-8 text-center">
                    <h1 class="h2">Bienvenue, {{ $user->nom }} !</h1>
                    <p class="text-muted">Découvrez notre bibliothèque et gérez vos emprunts</p>
                </div>
                <div class="col-md-8 text-center mt-3">
                    <a href="{{ route('livres.index') }}" class="btn btn-primary">
                        <i class="fas fa-book"></i> Parcourir les livres
                    </a>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="row mb-4 justify-content-center">
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="text-primary mb-2">
                                <i class="fas fa-book-reader fa-2x"></i>
                            </div>
                            <h3 class="h4">{{ $borrowedBooksCount }}</h3>
                            <p class="text-muted mb-0">Mes emprunts</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="text-success mb-2">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <h3 class="h4">{{ $availableBooks }}</h3>
                            <p class="text-muted mb-0">Livres disponibles</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="text-warning mb-2">
                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                            </div>
                            <h3 class="h4">{{ $myOverdueReturns }}</h3>
                            <p class="text-muted mb-0">Retards</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="text-danger mb-2">
                                <i class="fas fa-euro-sign fa-2x"></i>
                            </div>
                            <h3 class="h4">{{ number_format($myPendingPenalties, 2, ',', ' ') }}€</h3>
                            <p class="text-muted mb-0">Pénalités</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <!-- Mes emprunts actuels -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="mb-0">
                                <i class="fas fa-book-open me-2"></i>Mes emprunts actuels
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($myCurrentLoans->isEmpty())
                                <div class="text-center py-4">
                                    <i class="fas fa-book text-muted fa-3x mb-3"></i>
                                    <p class="text-muted">Aucun emprunt en cours</p>
                                    <a href="{{ route('livres.index') }}" class="btn btn-outline-primary btn-sm">
                                        Découvrir les livres
                                    </a>
                                </div>
                            @else
                                <div class="list-group list-group-flush">
                                    @foreach($myCurrentLoans as $loan)
                                        <div class="list-group-item px-0">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">{{ $loan->livre->titre ?? 'Livre inconnu' }}</h6>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        Retour prévu le {{ $loan->date_retour_prevue->format('d/m/Y') }}
                                                    </small>
                                                    @if($loan->date_retour_prevue->isPast())
                                                        <span class="badge bg-warning text-dark ms-2">En retard</span>
                                                    @endif
                                                </div>
                                                <small class="text-muted">
                                                    {{ $loan->livre->auteur ?? 'Auteur inconnu' }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-3 text-center">
                                    <a href="{{ route('livres.index') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i>Emprunter un autre livre
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Nouveautés -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-success text-white text-center">
                            <h5 class="mb-0">
                                <i class="fas fa-sparkles me-2"></i>Nouveautés
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($recentBooks->isEmpty())
                                <p class="text-muted text-center py-4">Aucune nouveauté pour le moment</p>
                            @else
                                <div class="row justify-content-center">
                                    @foreach($recentBooks as $book)
                                        <div class="col-md-6 mb-3">
                                            <div class="card border">
                                                <div class="card-body p-3 text-center">
                                                    <h6 class="card-title mb-1">{{ Str::limit($book->titre, 30) }}</h6>
                                                    <small class="text-muted d-block mb-2">{{ $book->auteur ?? 'Auteur inconnu' }}</small>
                                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                                        <span class="badge bg-success">
                                                            {{ $book->quantite_disponible }} disponible(s)
                                                        </span>
                                                        @if($book->quantite_disponible > 0)
                                                            <a href="{{ route('livres.emprunter', $book->id) }}" 
                                                               class="btn btn-primary btn-sm">
                                                                Emprunter
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-3 text-center">
                                    <a href="{{ route('livres.index') }}" class="btn btn-outline-success">
                                        Voir tous les livres
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alertes -->
            @if($myOverdueReturns > 0)
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="alert alert-warning text-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Attention :</strong> Vous avez {{ $myOverdueReturns }} emprunt(s) en retard. 
                        Veuillez retourner ces livres dès que possible pour éviter des pénalités supplémentaires.
                    </div>
                </div>
            </div>
            @endif

            @if($myPendingPenalties > 0)
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="alert alert-danger text-center" role="alert">
                        <i class="fas fa-euro-sign me-2"></i>
                        <strong>Pénalités en attente :</strong> Vous avez {{ number_format($myPendingPenalties, 2, ',', ' ') }}€ de pénalités à régler.
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
