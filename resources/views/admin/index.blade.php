@extends('admin.layouts.master')

@section('main-content')
<div class="container-fluid px-0 px-md-3">
    <!-- Search and Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.index') }}" class="row g-2 g-md-3">
                <div class="col-12 col-md-4">
                    <input type="text" name="search" placeholder="Search by name, email, or phone"
                        value="{{ request('search') }}" class="form-control">
                </div>
                <div class="col-12 col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                        </option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                        </option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <select name="truck_type" class="form-select">
                        <option value="">All Truck Types</option>
                        @php
                        $truckTypesArray = json_decode($truckTypes, true);
                        // Skip the first row (header) and process the data rows
                        for ($i = 1; $i < count($truckTypesArray); $i++) { $type=$truckTypesArray[$i];
                            echo '<option value="' .$type[0].'" '. (request(' truck_type')==$type[0] ? 'selected' : '' )
                            .'>';
                            echo $type[0] . ' (' . $type[1] . ')';
                            echo '</option>';
                            }
                            @endphp
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <!-- Stats Cards -->
    <div class="row g-2 g-md-3 mb-4">
        <div class="col-6 col-sm-3">
            <a href="{{ route('admin.drivers.filter', 'all') }}" class="text-decoration-none">
                <div class="card bg-primary text-white h-100 shadow-sm shadow-hover"
                    style="transition: box-shadow 0.3s;">
                    <div class="card-body p-2 p-md-3">
                        <h6 class="card-title fs-md-5">Total Drivers</h6>
                        <h4 class="mb-0 fs-6 fs-md-4">{{ $metrics['total'] }}</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-sm-3">
            <a href="{{ route('admin.drivers.filter', 'today') }}" class="text-decoration-none">
                <div class="card bg-success text-white h-100 shadow-md shadow-hover"
                    style="transition: box-shadow 0.3s;">
                    <div class="card-body p-2 p-md-3">
                        <h6 class="card-title fs-md-5">Registered Today</h6>
                        <h4 class="mb-0 fs-6 fs-md-4">{{ $metrics['today'] }}</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-sm-3">
            <a href="{{ route('admin.drivers.filter', 'approved') }}" class="text-decoration-none">
                <div class="card bg-info text-white h-100 shadow-md shadow-hover" style="transition: box-shadow 0.3s;">
                    <div class="card-body p-2 p-md-3">
                        <h6 class="card-title fs-md-5">Approved</h6>
                        <h4 class="mb-0 fs-6 fs-md-4">{{ $metrics['approved'] }}</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-sm-3">
            <a href="{{ route('admin.drivers.filter', 'pending') }}" class="text-decoration-none">
                <div class="card bg-warning text-white h-100 shadow-md shadow-hover"
                    style="transition: box-shadow 0.3s;">
                    <div class="card-body p-2 p-md-3">
                        <h6 class="card-title fs-md-5">Pending</h6>
                        <h4 class="mb-0 fs-6 fs-md-4">{{ $metrics['pending'] }}</h4>
                    </div>
                </div>
            </a>
        </div>
    </div>


    <!-- Charts Row -->
    <div class="row g-2 g-md-3 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Registrations (Last 7 Days)</h5>
                    <div id="lineChart" style="width: 100%; height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Truck Type Distribution</h5>
                    <div id="pieChart" style="width: 100%; height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Drivers Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="driversTable" class="table table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th data-priority="1">Name</th>
                            <th>Contact</th>
                            <th>Truck Type</th>
                            <th>Document</th>
                            <th data-priority="2">Status</th>
                            <th>Registered</th>
                            <th data-priority="3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($drivers as $driver)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $driver->full_name }}</td>
                            <td>
                                <div class="text-nowrap">{{ $driver->email }}</div>
                                <small class="text-muted">{{ $driver->phone }}</small>
                            </td>
                            <td>{{ $driver->truck_type }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $driver->document_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-alt"></i> View
                                </a>
                            </td>
                            <td>
                                <span
                                    class="badge bg-{{ $driver->status == 'approved' ? 'success' : ($driver->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($driver->status) }}
                                </span>
                            </td>
                            <td>{{ $driver->created_at->format('d M Y, h:i A') }}</td>

                            <td>
                                <form action="{{ route('admin.drivers.updateStatus', $driver->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    @if ($driver->status == 'approved')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Disapprove">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                    @else
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Approve">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
    /* Custom responsive adjustments */
    .chart-container {
        min-height: 250px;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 0.75rem;
        }

        .card-title {
            font-size: 1rem;
        }
    }
</style>
@endpush


@push('scripts')
<!-- Load Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    // Load Google Charts
    google.charts.load('current', {
        'packages': ['corechart']
    });

    // Set callback when Google Charts is loaded
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        // Pie Chart
        var pieData = google.visualization.arrayToDataTable(<?= $truckTypes ?>);
        var pieOptions = {
            title: 'Truck Type Distribution',
            pieHole: 0.4,
            is3D: true,
            chartArea: {
                width: '90%',
                height: '80%'
            },
            legend: {
                position: 'labeled'
            }
        };
        var pieChart = new google.visualization.PieChart(document.getElementById('pieChart'));
        pieChart.draw(pieData, pieOptions);

        // Line Chart
        var lineData = google.visualization.arrayToDataTable(<?= $registrationTrends ?>);

        var lineOptions = {
            title: '',
            curveType: 'function',
            legend: {
                position: 'bottom',
                textStyle: {
                    fontSize: 12
                }
            },
            chartArea: {
                width: '85%',
                height: '70%'
            },
            hAxis: {
                title: 'Date',
                textStyle: {
                    fontSize: 11
                },
                slantedText: true,
                slantedTextAngle: 45,
                gridlines: {
                    count: 1,
                    color: '#f0f0f0'
                },
                showTextEvery: 1, // force all labels to show
            },
            vAxis: {
                title: 'Registrations',
                minValue: 0,
                textStyle: {
                    fontSize: 11
                },
                gridlines: {
                    color: '#f0f0f0'
                }
            },
            pointSize: 5,
            colors: ['#1a73e8'],
            tooltip: {
                textStyle: {
                    fontSize: 12
                }
            }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart'));
        lineChart.draw(lineData, lineOptions);
    }

    // Resize charts when window resizes
    $(window).resize(function() {
        drawCharts();
    });

    // Initialize DataTable (keep your existing code)
    $(document).ready(function() {
        $('#driversTable').DataTable({
            responsive: true,
            paging: false,
            searching: false,
            info: false,
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 2,
                    targets: 4
                },
                {
                    responsivePriority: 3,
                    targets: 6
                }
            ]
        });
    });
</script>
@endpush