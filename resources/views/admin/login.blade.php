<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-sm">
        <h2 class="text-xl font-bold mb-4 text-center">Admin Login</h2>

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('admin.login') }}" id="loginForm" method="POST">
            @csrf

            <div class="text-amber-100 text-sm text-center bg-amber-800 py-2 px-4 rounded-md shadow-sm">
                admin@example.com, password123
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required
                    class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>



            <div class="d-grid">
                <button id="submitBtn" type="submit"
                    class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                    <span id="btnText">Login</span>
                    <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                        aria-hidden="true"></span>
                </button>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('loginForm');
        form.addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');

            btn.setAttribute('disabled', true);
            btnText.textContent = "Processing...";
            btnSpinner.classList.remove('d-none');
        });
    });
    </script>
</body>

</html>