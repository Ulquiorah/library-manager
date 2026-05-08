@extends('layouts.app')

@section('title', 'Accueil')
@section('main_class', 'py-0')
@section('footer_class', 'mt-0')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}" type="text/css">
<style>
/* Vérification que le CSS est bien chargé */
.home-container {
    background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
    min-height: 100vh;
}

.home-header {
    background: white;
    border-bottom: 1px solid #e5e7eb;
    padding: 2rem 0;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}

.welcome-section {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.welcome-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.welcome-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.welcome-subtitle {
    color: #6b7280;
    margin: 0.25rem 0 0 0;
}

.header-stats {
    display: flex;
    gap: 2rem;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.stat-item i {
    font-size: 1.25rem;
    color: #4f46e5;
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.home-main {
    padding: 3rem 0;
}

section {
    margin-bottom: 3rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title i {
    color: #4f46e5;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.action-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.5rem;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.action-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    border-color: #4f46e5;
}

.action-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    margin-bottom: 1rem;
}

.action-card h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.action-card p {
    color: #6b7280;
    margin: 0;
    font-size: 0.875rem;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: #f9fafb;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: #9ca3af;
    font-size: 2rem;
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    color: #6b7280;
    margin: 0 0 1.5rem 0;
}

.loans-grid {
    display: grid;
    gap: 1.5rem;
}

.loan-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    gap: 1.5rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.loan-card:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.loan-cover {
    flex-shrink: 0;
    width: 80px;
    height: 120px;
    border-radius: 8px;
    overflow: hidden;
    background: #f9fafb;
}

.loan-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cover-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 2rem;
}

.loan-details {
    flex: 1;
}

.book-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.book-author {
    color: #6b7280;
    margin: 0 0 1rem 0;
    font-size: 0.875rem;
}

.loan-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.return-date {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.875rem;
}

.return-date i {
    color: #4f46e5;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.status-badge.active {
    background: #dcfce7;
    color: #10b981;
}

.status-badge.overdue {
    background: #fef3c7;
    color: #f59e0b;
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.loans-count {
    background: #4f46e5;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.view-all-link {
    color: #4f46e5;
    text-decoration: none;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.view-all-link:hover {
    gap: 0.75rem;
    color: #4338ca;
}

.books-carousel {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1.5rem;
}

.book-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.book-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.book-cover {
    position: relative;
    height: 200px;
    background: #f9fafb;
}

.book-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.availability-badge {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.availability-badge.available {
    background: #dcfce7;
    color: #10b981;
}

.availability-badge.unavailable {
    background: #fee2e2;
    color: #ef4444;
}

.book-info {
    padding: 1rem;
}

.book-info .book-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
    line-height: 1.3;
}

.book-info .book-author {
    color: #6b7280;
    margin: 0 0 1rem 0;
    font-size: 0.875rem;
    line-height: 1.3;
}

.book-actions {
    margin-top: auto;
}

.borrow-form {
    display: inline;
}

.alerts-container {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-width: 400px;
}

.alert {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    gap: 1rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    animation: slideIn 0.3s ease-out;
}

.alert-warning {
    border-left: 4px solid #f59e0b;
}

.alert-danger {
    border-left: 4px solid #ef4444;
}

.alert-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.alert-warning .alert-icon {
    background: #fef3c7;
    color: #f59e0b;
}

.alert-danger .alert-icon {
    background: #fee2e2;
    color: #ef4444;
}

.alert-content h4 {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.25rem 0;
}

.alert-content p {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .welcome-section {
        flex-direction: column;
        gap: 1rem;
    }
    
    .welcome-title {
        font-size: 1.5rem;
    }
    
    .header-stats {
        justify-content: center;
    }
    
    .home-main {
        padding: 2rem 0;
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
    
    .loans-grid {
        grid-template-columns: 1fr;
    }
    
    .books-carousel {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .alerts-container {
        position: static;
        margin: 2rem 1rem;
        max-width: none;
    }
    
    .loan-card {
        flex-direction: column;
        text-align: center;
    }
    
    .loan-cover {
        width: 100%;
        height: 200px;
        margin: 0 auto 1rem;
    }
    
    .loan-info {
        flex-direction: column;
        gap: 0.75rem;
    }
}
</style>
@endpush

@section('content')
<div class="home-container">
    <!-- Header Section -->
    <header class="home-header">
        <div class="container">
            <div class="header-content">
                <div class="welcome-section">
                    <div class="welcome-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h1 class="welcome-title">Bienvenue, {{ $user->nom }} !</h1>
                    <p class="welcome-subtitle">Gérez vos emprunts et découvrez notre collection</p>
                </div>
                <div class="header-stats">
                    <div class="stat-item">
                        <i class="fas fa-book"></i>
                        <span class="stat-value">{{ $borrowedBooksCount }}</span>
                        <span class="stat-label">Emprunts</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-check-circle"></i>
                        <span class="stat-value">{{ $availableBooks }}</span>
                        <span class="stat-label">Disponibles</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="home-main">
        <div class="container">
            <!-- Quick Actions -->
            <section class="quick-actions">
                <h2 class="section-title">
                    <i class="fas fa-bolt"></i>
                    Actions rapides
                </h2>
                <div class="actions-grid">
                    <a href="{{ route('livres.index') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>Rechercher un livre</h3>
                        <p>Parcourez notre catalogue</p>
                    </a>
                    
                    <a href="{{ route('livres.index') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3>Nouveautés</h3>
                        <p>Découvrez les derniers ajouts</p>
                    </a>
                    
                    <div class="action-card" onclick="showLoansHistory()">
                        <div class="action-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3>Historique</h3>
                        <p>Vos emprunts passés</p>
                    </div>
                </div>
            </section>

            <!-- Current Loans -->
            <section class="current-loans">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-book-reader"></i>
                        Mes emprunts actuels
                    </h2>
                    @if(!$myCurrentLoans->isEmpty())
                        <span class="loans-count">{{ $myCurrentLoans->count() }} emprunt(s)</span>
                    @endif
                </div>
                
                @if($myCurrentLoans->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <h3>Aucun emprunt en cours</h3>
                        <p>Commencez à explorer notre collection !</p>
                        <a href="{{ route('livres.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Rechercher des livres
                        </a>
                    </div>
                @else
                    <div class="loans-grid">
                        @foreach($myCurrentLoans as $loan)
                            <div class="loan-card">
                                <div class="loan-cover">
                                    @if($loan->livre->photo)
                                        <img src="{{ asset('storage/' . $loan->livre->photo) }}" alt="{{ $loan->livre->titre }}">
                                    @else
                                        <div class="cover-placeholder">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="loan-details">
                                    <h4 class="book-title">{{ $loan->livre->titre ?? 'Livre inconnu' }}</h4>
                                    <p class="book-author">{{ $loan->livre->auteur ?? 'Auteur inconnu' }}</p>
                                    <div class="loan-info">
                                        <div class="return-date">
                                            <i class="fas fa-calendar"></i>
                                            Retour: {{ $loan->date_retour_prevue->format('d/m/Y') }}
                                        </div>
                                        @if($loan->date_retour_prevue->isPast())
                                            <span class="status-badge overdue">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                En retard
                                            </span>
                                        @else
                                            <span class="status-badge active">
                                                <i class="fas fa-clock"></i>
                                                En cours
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- Recent Books -->
            <section class="recent-books">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-sparkles"></i>
                        Nouveautés
                    </h2>
                    <a href="{{ route('livres.index') }}" class="view-all-link">
                        Voir tout <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                @if($recentBooks->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3>Aucune nouveauté</h3>
                        <p>Revenez bientôt pour découvrir les derniers ajouts</p>
                    </div>
                @else
                    <div class="books-carousel">
                        @foreach($recentBooks->take(6) as $book)
                            <div class="book-card">
                                <div class="book-cover">
                                    @if($book->photo)
                                        <img src="{{ asset('storage/' . $book->photo) }}" alt="{{ $book->titre }}">
                                    @else
                                        <div class="cover-placeholder">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif>
                                    @if($book->quantite_disponible > 0)
                                        <div class="availability-badge available">
                                            <i class="fas fa-check"></i>
                                            Disponible
                                        </div>
                                    @else
                                        <div class="availability-badge unavailable">
                                            <i class="fas fa-times"></i>
                                            Indisponible
                                        </div>
                                    @endif
                                </div>
                                <div class="book-info">
                                    <h4 class="book-title">{{ Str::limit($book->titre, 25) }}</h4>
                                    <p class="book-author">{{ $book->auteur ?? 'Auteur inconnu' }}</p>
                                    <div class="book-actions">
                                        @if($book->quantite_disponible > 0)
                                            <form method="POST" action="{{ route('livres.emprunter', $book->id) }}" class="borrow-form">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-hand-holding-heart me-1"></i>Emprunter
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-ban me-1"></i>Indisponible
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </main>

    <!-- Alerts -->
    @if($myOverdueReturns > 0 || $myPendingPenalties > 0)
        <div class="alerts-container">
            @if($myOverdueReturns > 0)
                <div class="alert alert-warning">
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="alert-content">
                        <h4>Retards à signaler</h4>
                        <p>Vous avez {{ $myOverdueReturns }} emprunt(s) en retard. Veuillez les retourner rapidement.</p>
                    </div>
                </div>
            @endif
            
            @if($myPendingPenalties > 0)
                <div class="alert alert-danger">
                    <div class="alert-icon">
                        <i class="fas fa-euro-sign"></i>
                    </div>
                    <div class="alert-content">
                        <h4>Pénalités en attente</h4>
                        <p>Vous avez {{ number_format($myPendingPenalties, 2, ',', ' ') }}€ de pénalités à régler.</p>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>

<script>
function showLoansHistory() {
    // Rediriger vers l'historique des emprunts
    window.location.href = '{{ route("livres.index") }}';
}
</script>
@endsection
