@extends('layouts.app')

@section('title', $livre->titre)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $livre->titre }}</h4>
                    <div>
                        @if(auth()->user()->role_id >= 2)
                        <a href="{{ route('livres.edit', $livre) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        @endif
                        <a href="{{ route('livres.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($livre->photo)
                                <img src="{{ asset('storage/' . $livre->photo) }}" alt="{{ $livre->titre }}" class="img-fluid rounded mb-3">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 300px;">
                                    <i class="fas fa-book fa-4x text-muted"></i>
                                </div>
                            @endif

                            <h6 class="text-muted">Auteur</h6>
                            <p class="mb-3">{{ $livre->auteur }}</p>

                            @if($livre->isbn)
                            <h6 class="text-muted">ISBN</h6>
                            <p class="mb-3">{{ $livre->isbn }}</p>
                            @endif

                            @if($livre->categorie)
                            <h6 class="text-muted">Catégorie</h6>
                            <p class="mb-3">
                                <span class="badge bg-secondary">{{ $livre->categorie }}</span>
                            </p>
                            @endif

                            @if($livre->date_publication)
                            <h6 class="text-muted">Date de publication</h6>
                            <p class="mb-3">{{ $livre->date_publication->format('d/m/Y') }}</p>
                            @endif

                            @if($livre->editeur)
                            <h6 class="text-muted">Éditeur</h6>
                            <p class="mb-3">{{ $livre->editeur }}</p>
                            @endif
                        </div>

                        <div class="col-md-8">
                            @if($livre->description)
                            <h6 class="text-muted">Description</h6>
                            <p class="mb-3">{{ $livre->description }}</p>
                            @endif

                            @if($livre->resume)
                            <h6 class="text-muted">Résumé</h6>
                            <p class="mb-3">{{ $livre->resume }}</p>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row text-center">
                        <div class="col-md-4">
                            <h5 class="text-success">{{ $livre->quantite_disponible }}</h5>
                            <small class="text-muted">Disponibles</small>
                        </div>
                        <div class="col-md-4">
                            <h5 class="text-primary">{{ $livre->quantite }}</h5>
                            <small class="text-muted">Total</small>
                        </div>
                        <div class="col-md-4">
                            <h5 class="text-warning">{{ $livre->empruntsCourants->count() }}</h5>
                            <small class="text-muted">Empruntés</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Emprunts actuels -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Emprunts actuels</h6>
                </div>
                <div class="card-body">
                    @if($livre->emprunts->isEmpty())
                        <p class="text-muted text-center mb-0">Aucun emprunt en cours</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($livre->emprunts as $emprunt)
                                <li class="list-group-item px-0">
                                    <strong>{{ $emprunt->user->nom }}</strong>
                                    <div class="small text-muted">
                                        Retour prévu : {{ $emprunt->date_retour_prevue->format('d/m/Y') }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            @if(auth()->user()->role_id >= 2)
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Actions administrateur</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('livres.destroy', $livre) }}"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-trash"></i> Supprimer le livre
                        </button>
                    </form>
                </div>
            </div>
            @else
            <!-- Actions utilisateur -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    @if(auth()->user()->role_id < 2)
                        @if($livre->quantite_disponible > 0)
                            <form action="{{ route('livres.emprunter', $livre) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm w-100 mb-2">
                                    <i class="fas fa-plus"></i> Emprunter
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-sm w-100 mb-2" disabled>
                                <i class="fas fa-ban"></i> Indisponible
                            </button>
                        @endif
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection