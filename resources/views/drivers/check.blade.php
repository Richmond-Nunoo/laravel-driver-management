<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Check Registration Status</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow rounded-4">
                    <div class="card-body p-4">
                        <h4 class="mb-4 text-center">Check Your Registration Status</h4>

                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif

                        <form action="{{ route('drivers.check.status') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="identifier" class="form-label">Email or Phone Number</label>
                                <input type="text" name="identifier" class="form-control"
                                    placeholder="Enter email or phone" required>
                            </div>
                            <div class="d-grid">
                                <button id="checkBtn" type="submit" class="btn btn-primary">
                                    <span id="checkBtnText">Check Status</span>
                                    <span id="checkBtnSpinner" class="spinner-border spinner-border-sm d-none ms-2"
                                        role="status" aria-hidden="true"></span>
                                </button>
                            </div>

                        </form>

                        <div class="text-center mt-4">
                            <a href="{{ route('index') }}" class="btn btn-outline-secondary" id="checkStatusBtn">
                                Back to Registration
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.querySelector('form').addEventListener('submit', function() {
        const checkBtn = document.getElementById('checkBtn');
        const checkBtnText = document.getElementById('checkBtnText');
        const checkBtnSpinner = document.getElementById('checkBtnSpinner');

        checkBtn.setAttribute('disabled', true);
        checkBtnText.textContent = "Processing...";
        checkBtnSpinner.classList.remove('d-none');


        // Disable the Already Registered button
        checkStatusBtn.classList.add('disabled');
        checkStatusBtn.setAttribute('aria-disabled', 'true');
        checkStatusBtn.style.pointerEvents = 'none';
    });
    </script>

</body>

</html>
