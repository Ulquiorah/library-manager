@extends('layouts.app')

@section('title', 'Tableau de bord')
@section('main_class', 'py-0')
@section('footer_class', 'mt-0')

@section('content')
<div class="container-fluid dashboard-layout px-0">
    <div class="row g-0">
        @if(auth()->user()->role_id >= 2)
        <div class="col-lg-3 col-xl-2 pe-lg-3 mb-3 mb-lg-0">
            @include('dashboard.partials.sidebar')
        </div>
        @endif

        <div class="{{ auth()->user()->role_id >= 2 ? 'col-lg-9 col-xl-10' : 'col-12' }} px-3 px-lg-4">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h1 class="h2">Bienvenue, {{ $user->nom }} !</h1>
                    <p class="text-muted">Rôle: <strong>{{ $user->role->type ?? 'Utilisateur' }}</strong></p>
                </div>
            </div>

            <div class="row">
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

            <div class="row mt-2">
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
                    <!-- <div class="alert alert-info mb-0">
                        Utilisez la sidebar pour naviguer entre <strong>Général</strong>, <strong>Administration</strong> et <strong>Catégories</strong>.
                    </div> -->
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
