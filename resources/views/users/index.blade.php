@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')
@section('main_class', 'py-0')
@section('footer_class', 'mt-0')

@push('styles')
<style>
.avatar-lg {
    width: 48px;
    height: 48px;
    font-size: 18px;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #098fe9 100%);
}

.table th:nth-child(2),
.table td:nth-child(2) {
    width: 300px;
}

.table th:nth-child(3),
.table td:nth-child(3) {
    width: 200px;
}

.table th:nth-child(4),
.table td:nth-child(4) {
    width: 150px;
}

.table th:nth-child(5),
.table td:nth-child(5) {
    width: 280px;
}
</style>
@endpush

@section('content')
<div class="container-fluid dashboard-layout px-0">
    <div class="row g-0">
        <div class="col-lg-3 col-xl-2 pe-lg-3 mb-3 mb-lg-0">
            @include('dashboard.partials.sidebar')
        </div>

        <div class="col-lg-9 col-xl-10 px-3 px-lg-4">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h1 class="h2">Gestion des utilisateurs</h1>
                    <p class="text-muted">Gérez les rôles et permissions des utilisateurs</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="badge bg-primary">
                        <i class="fas fa-users me-1"></i>{{ $users->total() }} utilisateur(s)
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2"></i>Liste des utilisateurs
                        <span class="badge bg-primary ms-2">{{ $users->total() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Rôle actuel</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-lg bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm">
                                                    <span class="fw-bold">{{ strtoupper(substr($user->nom, 0, 1)) }}</span>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $user->nom }}</div>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                    @if(auth()->id() === $user->id)
                                                        <span class="badge bg-info ms-2 mt-1">Vous</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->contact ?? 'Non renseigné' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->role_id === 1 ? 'secondary' : ($user->role_id === 2 ? 'primary' : 'danger') }}">
                                                {{ $user->role->type }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <button type="button" 
                                                        class="btn btn-primary btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editRoleModal{{ $user->id }}"
                                                        title="Modifier le rôle">
                                                    <i class="fas fa-user-edit me-1"></i>
                                                    Modifier
                                                </button>
                                                
                                                <div class="dropdown">
                                                    <button type="button" 
                                                            class="btn btn-success btn-sm dropdown-toggle" 
                                                            data-bs-toggle="dropdown"
                                                            title="Changer le rôle rapidement">
                                                        <i class="fas fa-user-tag me-1"></i>
                                                        Rôle
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @foreach($roles as $role)
                                                            <li>
                                                                <button class="dropdown-item quick-role-change" 
                                                                        data-user-id="{{ $user->id }}" 
                                                                        data-role-id="{{ $role->id }}"
                                                                        data-role-name="{{ $role->type }}"
                                                                        {{ $user->role_id === $role->id ? 'disabled' : '' }}>
                                                                    <i class="fas fa-{{ $role->id === 1 ? 'user' : ($role->id === 2 ? 'book' : 'crown') }} me-2"></i>
                                                                    {{ $role->type }}
                                                                    @if($user->role_id === $role->id)
                                                                        <span class="badge bg-success ms-2">Actuel</span>
                                                                    @endif
                                                                </button>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                
                                                @if(auth()->id() !== $user->id)
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-danger btn-sm" 
                                                                title="Supprimer l'utilisateur"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                                                            <i class="fas fa-trash-alt me-1"></i>
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-secondary btn-sm" disabled title="Vous ne pouvez pas supprimer votre propre compte">
                                                        <i class="fas fa-user-shield me-1"></i>
                                                        Vous
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Aucun utilisateur trouvé</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals pour l'édition des rôles -->
@foreach($users as $user)
    <div class="modal fade" id="editRoleModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier le rôle de {{ $user->nom }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Rôle actuel</label>
                            <div class="alert alert-info">
                                <strong>{{ $user->role->type }}</strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="role_id_{{ $user->id }}" class="form-label">Nouveau rôle</label>
                            <select name="role_id" id="role_id_{{ $user->id }}" class="form-select" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->role_id === $role->id ? 'selected' : '' }}>
                                        {{ $role->type }} - {{ $role->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if(auth()->id() === $user->id)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Vous modifiez votre propre rôle. Soyez prudent !
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du changement rapide de rôle
    document.querySelectorAll('.quick-role-change').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const userId = this.dataset.userId;
            const roleId = this.dataset.roleId;
            const roleName = this.dataset.roleName;
            
            if (confirm(`Changer le rôle en "${roleName}" ?`)) {
                fetch(`/users/${userId}/role`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        role_id: roleId,
                        _method: 'PATCH'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.error || 'Une erreur est survenue');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                });
            }
        });
    });
});
</script>
@endpush
