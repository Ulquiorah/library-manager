@extends('layouts.app')

@section('title', 'Accueil')
@section('main_class', 'py-0')
@section('footer_class', 'mt-0')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}" type="text/css">
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
                    <div class="slider-controls">
                        <button class="slider-btn prev" onclick="slideBooks(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="slider-btn next" onclick="slideBooks(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
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
                    <div class="books-slider-container">
                        <div class="books-slider" id="booksSlider">
                            @foreach($recentBooks->take(6) as $book)
                                <div class="book-card">
                                    <div class="book-cover">
                                        @if($book->photo)
                                            <img src="{{ asset('storage/' . $book->photo) }}" alt="{{ $book->titre }}">
                                        @else
                                            <div class="cover-placeholder">
                                                <i class="fas fa-book"></i>
                                            </div>
                                        @endif
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
                    </div>
                    <div class="slider-dots">
                        <span class="dot active" onclick="goToSlide(0)"></span>
                        <span class="dot" onclick="goToSlide(1)"></span>
                        <span class="dot" onclick="goToSlide(2)"></span>
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
let currentSlide = 0;
const totalSlides = 3; // Seulement 3 slides pour 3 points

function slideBooks(direction) {
    const slider = document.getElementById('booksSlider');
    const maxSlide = totalSlides - 1;
    
    currentSlide += direction;
    
    if (currentSlide < 0) {
        currentSlide = maxSlide;
    } else if (currentSlide > maxSlide) {
        currentSlide = 0;
    }
    
    updateSlider();
    updateDots();
}

function goToSlide(slideIndex) {
    currentSlide = slideIndex;
    updateSlider();
    updateDots();
}

function updateSlider() {
    const slider = document.getElementById('booksSlider');
    const slideWidth = 316; // 300px + 16px gap
    slider.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
}

function updateDots() {
    const dots = document.querySelectorAll('.dot');
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
    });
}

// Auto-slide every 5 seconds
setInterval(() => {
    slideBooks(1);
}, 5000);

// Touch support for mobile
let touchStartX = 0;
let touchEndX = 0;

const sliderContainer = document.querySelector('.books-slider-container');
if (sliderContainer) {
    sliderContainer.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });
    
    sliderContainer.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });
}

function handleSwipe() {
    if (touchEndX < touchStartX - 50) {
        slideBooks(1); // Swipe left
    } else if (touchEndX > touchStartX + 50) {
        slideBooks(-1); // Swipe right
    }
}
</script>
@endsection
