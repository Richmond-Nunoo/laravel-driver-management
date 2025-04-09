<div class="sidebar bg-light text-dark d-flex flex-column flex-shrink-0 p-3 border-end shadow-sm"
    style="width: 250px; min-height: 100vh;">

    <!-- Sidebar Header -->
    <div class="text-center mb-4">
        <i class="fas fa-user-shield fs-1 text-primary mb-2"></i> {{-- Large Icon --}}
        <a href="{{ route('admin.index') }}" class="d-inline-block text-dark text-decoration-none fw-semibold fs-5">
            Admin
        </a>
    </div>

    <hr>

    <!-- Main Navigation -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('admin.index') }}"
                class="nav-link {{ request()->routeIs('admin.index') ? 'active text-white bg-primary' : 'text-dark' }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.drivers.index') }}"
                class="nav-link {{ request()->is('admin/drivers*') ? 'active text-white bg-primary' : 'text-dark' }}">
                <i class="fas fa-users me-2"></i> Drivers
            </a>
        </li>

    </ul>
    <hr>
    <!-- Logout Button at Bottom -->
    <div class="mt-auto">
        <hr>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>
    <!-- User Menu -->

</div>