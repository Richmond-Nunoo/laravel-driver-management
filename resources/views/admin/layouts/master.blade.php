<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.head')

<body>
    <!-- Sidebar -->
    @include('admin.layouts.sidebar')

    <!-- Mobile Toggle Button -->
    <button class="btn btn-dark" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Content -->
    <div class="main-content">
        @include('admin.layouts.header')

        <main class="container-fluid py-4">
            @yield('main-content')
        </main>

        @include('admin.layouts.footer')
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Toggle sidebar on button click
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 992 && !sidebar.contains(event.target) &&
                    event.target !== sidebarToggle && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>

    @stack('scripts')
    @stack('styles')
</body>

</html>