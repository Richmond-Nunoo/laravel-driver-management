<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Driver Registration</title>
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
                        <h4 class="mb-4 text-center">Driver Registration</h4>

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">

                            @csrf

                            <!-- Honeypot field to prevent bot submissions -->
                            <div style="display: none;">
                                <label for="honeypot" class="form-label">Leave this field empty</label>
                                <input type="text" name="honeypot" id="honeypot" class="form-control" value="">
                            </div>

                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}"
                                    placeholder="e.g., Kwame Peprah" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                    placeholder="e.g., kwamepeprah@gmail.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" required
                                    pattern="[0-9]{10}" maxlength="10"
                                    title="Please enter a valid 10-digit phone number."
                                    placeholder="e.g., 024 123 4567">
                            </div>

                            <div class="mb-3">
                                <label for="truck_type" class="form-label">Truck Type</label>
                                <select name="truck_type" class="form-select" required>
                                    <option value="">Select Truck Type</option>
                                    <option value="Tipper">Tipper</option>
                                    <option value="Flatbed">Flatbed</option>
                                    <option value="Tanker">Tanker</option>
                                    <option value="Container Carrier">Container Carrier</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="document" class="form-label">Upload ID or Truck Document
                                    (PDF/Image)</label>
                                <input type="file" name="document" class="form-control" accept=".pdf,.jpg,.jpeg,.png"
                                    required>
                            </div>

                            <div class="d-grid mb-2">
                                <button id="submitBtn" type="submit" class="btn btn-primary ">
                                    <span id="btnText">Submit Registration</span>
                                    <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                                        aria-hidden="true"></span>
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('drivers.check.form') }}" class="btn btn-outline-secondary"
                                    id="checkStatusBtn">
                                    Already Registered? Check Your Status
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            // Honeypot field check: If it's filled, prevent the form submission
            if (document.getElementById('honeypot').value) {
                e.preventDefault(); // Prevent the form from being submitted
            } else {
                const btn = document.getElementById('submitBtn');
                const btnText = document.getElementById('btnText');
                const btnSpinner = document.getElementById('btnSpinner');

                const checkStatusBtn = document.getElementById('checkStatusBtn');

                btn.setAttribute('disabled', true);
                btnText.textContent = "Processing...";
                btnSpinner.classList.remove('d-none');

                // Disable the Already Registered button
                checkStatusBtn.classList.add('disabled');
                checkStatusBtn.setAttribute('aria-disabled', 'true');
                checkStatusBtn.style.pointerEvents = 'none';
            }
        });
    </script>

</body>

</html>