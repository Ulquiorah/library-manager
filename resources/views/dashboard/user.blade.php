@extends('layouts.app')

@section('title', 'Dashboard Utilisateur')
@section('main_class', 'py-4')
@section('footer_class', 'mt-0')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard-user.css') }}" type="text/css">
@endpush

@section('content')
<div class="user-dashboard">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="container">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->nom, 0, 1)) }}
                </div>
                <div class="user-details">
                    <h1>{{ $user->nom }} {{ $user->prenom ?? '' }}</h1>
                    <p>{{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-value">{{ $borrowedBooks }}</div>
                <div class="stat-label">Mes emprunts</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $availableBooks }}</div>
                <div class="stat-label">Livres disponibles</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-value">{{ $overdueReturns }}</div>
                <div class="stat-label">Retards</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-euro-sign"></i>
                </div>
                <div class="stat-value">{{ number_format($pendingPenalties, 2, ',', ' ') }}€</div>
                <div class="stat-label">Pénalités</div>
            </div>
        </div>

        <!-- Alertes -->
        @if($overdueReturns > 0 || $pendingPenalties > 0)
            <div class="alerts-section">
                @if($overdueReturns > 0)
                    <div class="alert alert-warning">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="alert-content">
                            <h4>Retards à signaler</h4>
                            <p>Vous avez {{ $overdueReturns }} emprunt(s) en retard. Veuillez les retourner rapidement.</p>
                        </div>
                    </div>
                @endif
                
                @if($pendingPenalties > 0)
                    <div class="alert alert-danger">
                        <div class="alert-icon">
                            <i class="fas fa-euro-sign"></i>
                        </div>
                        <div class="alert-content">
                            <h4>Pénalités en attente</h4>
                            <p>Vous avez {{ number_format($pendingPenalties, 2, ',', ' ') }}€ de pénalités à régler.</p>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Mes emprunts actuels -->
        <div class="loans-section">
            <h2 class="section-title">
                <i class="fas fa-book-reader"></i>
                Mes emprunts actuels
            </h2>
            
            @if($currentLoans->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Aucun emprunt en cours</h3>
                    <p>Commencez à explorer notre collection !</p>
                </div>
            @else
                <div class="loans-grid">
                    @foreach($currentLoans as $loan)
                        <div class="loan-item">
                            <div class="loan-cover">
                                @if($loan->livre->photo)
                                    <img src="{{ asset('storage/' . $loan->livre->photo) }}" alt="{{ $loan->livre->titre }}">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #e5e7eb; color: #9ca3af;">
                                        <i class="fas fa-book"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="loan-details">
                                <div class="loan-title">{{ $loan->livre->titre ?? 'Livre inconnu' }}</div>
                                <div class="loan-date">
                                    <i class="fas fa-calendar"></i>
                                    Retour: {{ $loan->date_retour_prevue->format('d/m/Y') }}
                                </div>
                                @if($loan->date_retour_prevue->isPast())
                                    <div class="loan-status status-overdue">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        En retard
                                    </div>
                                @else
                                    <div class="loan-status status-active">
                                        <i class="fas fa-clock"></i>
                                        En cours
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

            </div>
</div>
@endsection
