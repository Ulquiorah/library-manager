<button class="btn btn-dark d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#dashboardSidebar" aria-controls="dashboardSidebar">
    <i class="fas fa-bars me-2"></i> Menu
</button>

<aside class="dashboard-sidebar d-none d-lg-block">
    <div class="dashboard-sidebar-header">
        <h5 class="mb-0">Menu admin</h5>
    </div>
    <div class="dashboard-sidebar-body p-3">
        <nav class="dashboard-sidebar-nav">
            <a href="{{ route('dashboard') }}" class="dashboard-sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home dashboard-sidebar-icon"></i>
                Général
            </a>
            <a href="{{ route('administration') }}" class="dashboard-sidebar-link {{ request()->routeIs('administration') ? 'active' : '' }}">
                <i class="fas fa-tools dashboard-sidebar-icon"></i>
                Administration
            </a>
            <a href="{{ route('users.index') }}" class="dashboard-sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fas fa-users dashboard-sidebar-icon"></i>
                Utilisateurs
            </a>
            <a href="{{ route('categories') }}" class="dashboard-sidebar-link {{ request()->routeIs('categories') ? 'active' : '' }}">
                <i class="fas fa-tags dashboard-sidebar-icon"></i>
                Catégories
            </a>
        </nav>

        <div class="dashboard-sidebar-footer">
            <div class="dashboard-sidebar-user">{{ auth()->user()->nom }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">Déconnexion</button>
            </form>
        </div>
    </div>
</aside>

<div class="offcanvas offcanvas-start dashboard-sidebar-offcanvas" tabindex="-1" id="dashboardSidebar" aria-labelledby="dashboardSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="dashboardSidebarLabel">Menu admin</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-3 dashboard-sidebar-body">
        <nav class="dashboard-sidebar-nav">
            <a href="{{ route('dashboard') }}" class="dashboard-sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home dashboard-sidebar-icon"></i>
                Général
            </a>
            <a href="{{ route('administration') }}" class="dashboard-sidebar-link {{ request()->routeIs('administration') ? 'active' : '' }}">
                <i class="fas fa-tools dashboard-sidebar-icon"></i>
                Administration
            </a>
            <a href="{{ route('users.index') }}" class="dashboard-sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fas fa-users dashboard-sidebar-icon"></i>
                Utilisateurs
            </a>
            <a href="{{ route('categories') }}" class="dashboard-sidebar-link {{ request()->routeIs('categories') ? 'active' : '' }}">
                <i class="fas fa-tags dashboard-sidebar-icon"></i>
                Catégories
            </a>
        </nav>

        <div class="dashboard-sidebar-footer">
            <div class="dashboard-sidebar-user">{{ auth()->user()->nom }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">Déconnexion</button>
            </form>
        </div>
    </div>
</div>
