@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2">Bienvenue, {{ $user->nom }} !</h1>
            <p class="text-muted">Rôle: <strong>{{ $user->role->type ?? 'Utilisateur' }}</strong></p>
        </div>
    </div>

    <div class="row">
        <!-- Statistiques -->
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="display-6">{{ $borrowedBooks }}</h2>
                    <p class="text-muted">Livres empruntés</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="display-6">{{ number_format($pendingPenalties, 2, ',', ' ') }}€</h2>
                    <p class="text-muted">Pénalités en attente</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="display-6">{{ $overdueReturns }}</h2>
                    <p class="text-muted">Retours en retard</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="display-6">{{ $availableBooks }}</h2>
                    <p class="text-muted">Livres disponibles</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ auth()->user()->role_id >= 2 ? 'Emprunts en cours' : 'Mes emprunts actuels' }}</h5>
                </div>
                <div class="card-body">
                    @if($currentLoans->isEmpty())
                        <p class="text-muted text-center py-4">{{ auth()->user()->role_id >= 2 ? 'Aucun emprunt en cours' : 'Aucun emprunt pour le moment' }}</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($currentLoans as $loan)
                                <li class="list-group-item">
                                    <strong>{{ $loan->livre->titre ?? 'Livre inconnu' }}</strong>
                                    @if(auth()->user()->role_id >= 2)
                                        <div class="small text-muted">Emprunté par : {{ $loan->user->nom }}</div>
                                    @endif
                                    <div class="small text-muted">
                                        Retour prévu le {{ $loan->date_retour_prevue->format('d/m/Y') }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Pénalités</h5>
                </div>
                <div class="card-body">
                    @if($pendingPenalties > 0)
                        <p class="text-muted text-center py-4">Montant à payer : {{ number_format($pendingPenalties, 2, ',', ' ') }}€</p>
                    @else
                        <p class="text-muted text-center py-4">Aucune pénalité</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role_id >= 2)
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Administration</h5>
                </div>
                <div class="card-body">
                    <!-- Onglets -->

                    <!-- Onglets -->
                    <ul class="nav nav-tabs" id="adminTab" role="tablist" style="gap: 0.5rem;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active admin-tab-btn" id="livres-tab" data-bs-toggle="tab" data-bs-target="#livres" type="button" role="tab">
                                Gérer les livres
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link admin-tab-btn" id="emprunts-tab" data-bs-toggle="tab" data-bs-target="#emprunts" type="button" role="tab">
                                Emprunts
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link admin-tab-btn" id="penalites-tab" data-bs-toggle="tab" data-bs-target="#penalites" type="button" role="tab">
                                Pénalités
                            </button>
                        </li>
                    </ul>
                    <style>
                        .admin-tab-btn {
                            color: #222 !important;
                            background: #fff !important;
                            border: 1px solid #17c6f5 !important;
                            margin-right: 0.5rem !important;
                        }
                        .admin-tab-btn.active {
                            color: #222 !important;
                            background: #eafaff !important;
                        }
                    </style>

                    <div class="tab-content" id="adminTabContent" style="margin-top: 20px;">
                        <!-- Onglet Livres -->
                        <div class="tab-pane fade show active" id="livres" role="tabpanel">
                            <a href="{{ route('livres.index') }}" class="btn btn-primary">
                                <i class="fas fa-book"></i> Gérer les livres
                            </a>
                        </div>

                        <!-- Onglet Emprunts -->
                        <div class="tab-pane fade" id="emprunts" role="tabpanel">
                            <ul class="nav nav-pills mb-3" id="empruntsSubTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="en-cours-tab" data-bs-toggle="tab" data-bs-target="#en-cours" type="button" role="tab">
                                        En cours ({{ $empruntsEnCours->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="retard-tab" data-bs-toggle="tab" data-bs-target="#retard" type="button" role="tab">
                                        En retard ({{ $empruntsEnRetard->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="historique-tab" data-bs-toggle="tab" data-bs-target="#historique" type="button" role="tab">
                                        Historique
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="empruntsSubTabContent">
                                <!-- En cours -->
                                <div class="tab-pane fade show active" id="en-cours" role="tabpanel">
                                    @if($empruntsEnCours->isEmpty())
                                        <p class="text-muted">Aucun emprunt en cours</p>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Livre</th>
                                                        <th>Emprunteur</th>
                                                        <th>Date emprunt</th>
                                                        <th>Retour prévu</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($empruntsEnCours as $emprunt)
                                                    <tr>
                                                        <td><strong>{{ $emprunt->livre->titre }}</strong></td>
                                                        <td>{{ $emprunt->user->nom }}</td>
                                                        <td>{{ $emprunt->date_emprunt->format('d/m/Y') }}</td>
                                                        <td>{{ $emprunt->date_retour_prevue->format('d/m/Y') }}</td>
                                                        <td>
                                                            <form action="{{ route('emprunts.return', $emprunt) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Confirmer le retour ?')">
                                                                    <i class="fas fa-undo"></i> Retourner
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>

                                <!-- En retard -->
                                <div class="tab-pane fade" id="retard" role="tabpanel">
                                    @if($empruntsEnRetard->isEmpty())
                                        <p class="text-muted">Aucun emprunt en retard</p>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Livre</th>
                                                        <th>Emprunteur</th>
                                                        <th>Retour prévu</th>
                                                        <th>Jours retard</th>
                                                        <th>Pénalité</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($empruntsEnRetard as $emprunt)
                                                    <tr>
                                                        <td><strong>{{ $emprunt->livre->titre }}</strong></td>
                                                        <td>{{ $emprunt->user->nom }}</td>
                                                        <td>{{ $emprunt->date_retour_prevue->format('d/m/Y') }}</td>
                                                        <td><span class="badge bg-danger">{{ $emprunt->jours_retard() }}</span></td>
                                                        <td>{{ number_format($emprunt->montant_penalite(), 2, ',', ' ') }}€</td>
                                                        <td>
                                                            <form action="{{ route('emprunts.return', $emprunt) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Confirmer le retour ?')">
                                                                    <i class="fas fa-undo"></i> Retourner
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>

                                <!-- Historique -->
                                <div class="tab-pane fade" id="historique" role="tabpanel">
                                    @if($historiqueEmprunts->isEmpty())
                                        <p class="text-muted">Aucun historique</p>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Livre</th>
                                                        <th>Emprunteur</th>
                                                        <th>Emprunt</th>
                                                        <th>Retour</th>
                                                        <th>Statut</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($historiqueEmprunts as $emprunt)
                                                    <tr>
                                                        <td><strong>{{ $emprunt->livre->titre }}</strong></td>
                                                        <td>{{ $emprunt->user->nom }}</td>
                                                        <td>{{ $emprunt->date_emprunt->format('d/m/Y') }}</td>
                                                        <td>{{ $emprunt->date_retour_reelle?->format('d/m/Y') ?? '-' }}</td>
                                                        <td>
                                                            @if($emprunt->statut === 'retourne')
                                                                <span class="badge bg-success">Retourné</span>
                                                            @else
                                                                <span class="badge bg-primary">{{ ucfirst($emprunt->statut) }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Onglet Pénalités -->
                        <div class="tab-pane fade" id="penalites" role="tabpanel">
                            @if($penalites->isEmpty())
                                <p class="text-muted">Aucune pénalité</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Emprunteur</th>
                                                <th>Livre</th>
                                                <th>Montant</th>
                                                <th>Statut</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($penalites as $penalite)
                                            <tr>
                                                <td>{{ $penalite->emprunt->user->nom }}</td>
                                                <td><strong>{{ $penalite->emprunt->livre->titre }}</strong></td>
                                                <td>{{ number_format($penalite->montant, 2, ',', ' ') }}€</td>
                                                <td>
                                                    @if($penalite->payee)
                                                        <span class="badge bg-success">Payée</span>
                                                    @else
                                                        <span class="badge bg-warning">Non payée</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!$penalite->payee)
                                                    <form action="{{ route('penalites.pay', $penalite) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Marquer comme payée ?')">
                                                            <i class="fas fa-check"></i> Marquer payée
                                                        </button>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
