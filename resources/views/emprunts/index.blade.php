@extends('layouts.app')

@section('title', 'Gestion des emprunts')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2">Gestion des emprunts</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour au tableau de bord
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-primary">{{ $stats['total_emprunts'] }}</h3>
                    <p class="text-muted mb-0">Emprunts totaux</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-success">{{ $stats['emprunts_en_cours'] }}</h3>
                    <p class="text-muted mb-0">En cours</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-warning">{{ $stats['emprunts_en_retard'] }}</h3>
                    <p class="text-muted mb-0">En retard</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-danger">{{ number_format($stats['penalites_total'], 2, ',', ' ') }}€</h3>
                    <p class="text-muted mb-0">Pénalités</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Onglets -->
    <ul class="nav nav-tabs" id="empruntsTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="en-cours-tab" data-bs-toggle="tab" data-bs-target="#en-cours" type="button" role="tab">En cours</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="retard-tab" data-bs-toggle="tab" data-bs-target="#retard" type="button" role="tab">En retard</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="historique-tab" data-bs-toggle="tab" data-bs-target="#historique" type="button" role="tab">Historique</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="penalites-tab" data-bs-toggle="tab" data-bs-target="#penalites" type="button" role="tab">Pénalités</button>
        </li>
    </ul>

    <div class="tab-content" id="empruntsTabContent">
        <!-- Emprunts en cours -->
        <div class="tab-pane fade show active" id="en-cours" role="tabpanel">
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    @if($empruntsEnCours->isEmpty())
                        <p class="text-muted text-center py-4">Aucun emprunt en cours</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Livre</th>
                                        <th>Emprunteur</th>
                                        <th>Date emprunt</th>
                                        <th>Date retour prévue</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($empruntsEnCours as $emprunt)
                                    <tr>
                                        <td>
                                            <strong>{{ $emprunt->livre->titre }}</strong><br>
                                            <small class="text-muted">{{ $emprunt->livre->auteur }}</small>
                                        </td>
                                        <td>{{ $emprunt->user->nom }}</td>
                                        <td>{{ $emprunt->date_emprunt->format('d/m/Y') }}</td>
                                        <td>
                                            {{ $emprunt->date_retour_prevue->format('d/m/Y') }}
                                            @if($emprunt->en_retard())
                                                <br><span class="badge bg-danger">En retard ({{ $emprunt->jours_retard() }} jours)</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('emprunts.return', $emprunt) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success"
                                                        onclick="return confirm('Confirmer le retour de ce livre ?')">
                                                    <i class="fas fa-undo"></i> Retourner
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $empruntsEnCours->links() }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Emprunts en retard -->
        <div class="tab-pane fade" id="retard" role="tabpanel">
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    @if($empruntsEnRetard->isEmpty())
                        <p class="text-muted text-center py-4">Aucun emprunt en retard</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Livre</th>
                                        <th>Emprunteur</th>
                                        <th>Date emprunt</th>
                                        <th>Date retour prévue</th>
                                        <th>Jours de retard</th>
                                        <th>Pénalité</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($empruntsEnRetard as $emprunt)
                                    <tr>
                                        <td>
                                            <strong>{{ $emprunt->livre->titre }}</strong><br>
                                            <small class="text-muted">{{ $emprunt->livre->auteur }}</small>
                                        </td>
                                        <td>{{ $emprunt->user->nom }}</td>
                                        <td>{{ $emprunt->date_emprunt->format('d/m/Y') }}</td>
                                        <td>{{ $emprunt->date_retour_prevue->format('d/m/Y') }}</td>
                                        <td><span class="badge bg-danger">{{ $emprunt->jours_retard() }}</span></td>
                                        <td>{{ number_format($emprunt->montant_penalite(), 2, ',', ' ') }}€</td>
                                        <td>
                                            <form action="{{ route('emprunts.return', $emprunt) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success"
                                                        onclick="return confirm('Confirmer le retour de ce livre ? Une pénalité sera appliquée.')">
                                                    <i class="fas fa-undo"></i> Retourner
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $empruntsEnRetard->links() }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Historique -->
        <div class="tab-pane fade" id="historique" role="tabpanel">
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    @if($historiqueEmprunts->isEmpty())
                        <p class="text-muted text-center py-4">Aucun emprunt dans l'historique</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Livre</th>
                                        <th>Emprunteur</th>
                                        <th>Date emprunt</th>
                                        <th>Date retour</th>
                                        <th>Statut</th>
                                        <th>Pénalité</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historiqueEmprunts as $emprunt)
                                    <tr>
                                        <td>
                                            <strong>{{ $emprunt->livre->titre }}</strong><br>
                                            <small class="text-muted">{{ $emprunt->livre->auteur }}</small>
                                        </td>
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
                                        <td>
                                            @if($emprunt->penalite)
                                                {{ number_format($emprunt->penalite->montant, 2, ',', ' ') }}€
                                                @if($emprunt->penalite->payee)
                                                    <span class="badge bg-success">Payée</span>
                                                @else
                                                    <span class="badge bg-warning">Non payée</span>
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $historiqueEmprunts->links() }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Pénalités -->
        <div class="tab-pane fade" id="penalites" role="tabpanel">
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    @if($penalites->isEmpty())
                        <p class="text-muted text-center py-4">Aucune pénalité</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Emprunteur</th>
                                        <th>Livre</th>
                                        <th>Date création</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($penalites as $penalite)
                                    <tr>
                                        <td>{{ $penalite->emprunt->user->nom }}</td>
                                        <td>
                                            <strong>{{ $penalite->emprunt->livre->titre }}</strong><br>
                                            <small class="text-muted">{{ $penalite->emprunt->livre->auteur }}</small>
                                        </td>
                                        <td>{{ $penalite->date_application->format('d/m/Y') }}</td>
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
                                                <button type="submit" class="btn btn-sm btn-success"
                                                        onclick="return confirm('Marquer cette pénalité comme payée ?')">
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
                        {{ $penalites->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection