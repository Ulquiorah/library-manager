@extends('layouts.app')

@section('title', 'Administration')
@section('main_class', 'py-0')
@section('footer_class', 'mt-0')

@section('content')
<div class="container-fluid dashboard-layout px-0">
    <div class="row g-0">
        <div class="col-lg-3 col-xl-2 pe-lg-3 mb-3 mb-lg-0">
            @include('dashboard.partials.sidebar')
        </div>

        <div class="col-lg-9 col-xl-10 px-3 px-lg-4">
            <div class="row mb-4">
                <div class="col-md-12">
                    <h1 class="h2 mb-0">Administration</h1>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Gestion de la bibliothèque</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="adminTab" role="tablist">
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

                    <div class="tab-content" id="adminTabContent">
                        <div class="tab-pane fade show active" id="livres" role="tabpanel">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('livres.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Ajouter un livre
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Auteur</th>
                                            <th>Catégorie</th>
                                            <th>Disponibles</th>
                                            <th>Empruntés</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($livres as $livre)
                                        <tr>
                                            <td>
                                                <strong>{{ $livre->titre }}</strong>
                                                <br>
                                                <small class="text-muted">ISBN : {{ $livre->isbn ?? '-' }}</small>
                                            </td>
                                            <td>{{ $livre->auteur }}</td>
                                            <td>{{ $livre->categorie ?? '-' }}</td>
                                            <td>{{ $livre->quantite_disponible }}/{{ $livre->quantite }}</td>
                                            <td>{{ $livre->empruntsCourants->count() }}</td>
                                            <td>
                                                <a href="{{ route('livres.show', $livre) }}" class="btn btn-outline-primary btn-sm">Voir</a>
                                                <a href="{{ route('livres.edit', $livre) }}" class="btn btn-outline-secondary btn-sm">Modifier</a>
                                                <form action="{{ route('livres.destroy', $livre) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce livre ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(method_exists($livres, 'links'))
                            <div class="d-flex justify-content-center mt-3">
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

                        <div class="tab-pane fade" id="emprunts" role="tabpanel">
                            <ul class="nav nav-pills mb-3" id="empruntsSubTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active admin-tab-btn" id="en-cours-tab" data-bs-toggle="tab" data-bs-target="#en-cours" type="button" role="tab">
                                        En cours ({{ $empruntsEnCours->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link admin-tab-btn" id="retard-tab" data-bs-toggle="tab" data-bs-target="#retard" type="button" role="tab">
                                        En retard ({{ $empruntsEnRetard->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link admin-tab-btn" id="historique-tab" data-bs-toggle="tab" data-bs-target="#historique" type="button" role="tab">
                                        Historique
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="empruntsSubTabContent">
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
</div>
@endsection
