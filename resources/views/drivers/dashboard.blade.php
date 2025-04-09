<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Driver Dashboard</title>
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
                        <h4 class="mb-4 text-center">Welcome, {{ $driver->full_name }}</h4>

                        <!-- Status Badge -->
                        <div class="text-center mb-4">
                            @php
                            $status = $driver->status;
                            $badgeClass = match ($status) {
                            'approved' => 'success',
                            'pending' => 'warning',
                            'rejected' => 'danger',
                            default => 'secondary',
                            };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }} px-3 py-2 fs-6 text-capitalize">
                                {{ $status }}
                            </span>
                        </div>

                        <ul class="list-group mb-4">
                            <li class="list-group-item"><strong>Email:</strong> {{ $driver->email }}</li>
                            <li class="list-group-item"><strong>Phone:</strong> {{ $driver->phone }}</li>
                            <li class="list-group-item"><strong>Truck Type:</strong> {{ $driver->truck_type }}</li>
                            <li class="list-group-item">
                                <strong>Document:</strong>
                                <a href="{{ Storage::url($driver->document_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary ms-2">
                                    View / Download
                                </a>
                            </li>
                        </ul>


                        <div class="text-center">
                            <a href="{{ route('index') }}" class="btn btn-secondary rounded-pill">Register
                                Another Driver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
