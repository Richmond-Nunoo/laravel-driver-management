@extends('admin.layouts.master')

@section('main-content')

<div class="container-fluid px-0 px-md-3">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            {{ isset($status) ? ucfirst($status) . ' Drivers' : 'All Drivers' }}
        </h4>
        <div>
            <!-- Export PDF Button -->
            <a href="{{ url('/admin/export-pdf') }}" class="btn bg-success btn-sm me-2">
                Export PDF
            </a>

            <!-- Add Driver Button -->
            <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary btn-sm me-2">
                <i class="fas fa-plus"></i> Add Driver
            </a>

            <!-- Show All Drivers Button -->
            <a href="{{ route('admin.drivers.index') }}" class="btn btn-info btn-sm">
                Show All Drivers
            </a>
        </div>
    </div>

    <!-- Drivers Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="driversTable" class="table table-striped table-hover w-100 nowrap">
                    <thead>
                        <tr>
                            <th data-priority="1">ID</th>
                            <th data-priority="1">Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th data-priority="2">Truck Type</th>
                            <th data-priority="3">Status</th>
                            <th>Document</th>
                            <th>Registered</th>
                            <th data-priority="4">Actions</th> <!-- Keep the column count consistent -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($drivers as $driver)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $driver->full_name }}</td>
                            <td>{{ $driver->email }}</td>
                            <td>{{ $driver->phone }}</td>
                            <td>{{ $driver->truck_type }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $driver->status == 'approved' ? 'success' : ($driver->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($driver->status) }}
                                </span>
                            </td>
                            <td>
                                @if($driver->document_path)
                                <a href="{{ asset('storage/' . $driver->document_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-alt"></i> View
                                </a>
                                @else
                                <span class="text-muted">None</span>
                                @endif
                            </td>
                            <td>{{ $driver->created_at->format('d M Y, h:i A') }}</td>

                            <td class="text-nowrap">
                                <div class="d-flex gap-1">

                                    {{-- Approve/Reject --}}
                                    <form action="{{ route('admin.drivers.updateStatus', $driver->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if ($driver->status == 'approved')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Disapprove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @else
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @endif
                                    </form>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.drivers.edit', $driver->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.drivers.destroy', $driver->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger dltBtn"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No drivers found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
    function deleteData(id) {

    }
</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.dltBtn').click(function(e) {
            var form = $(this).closest('form');
            var dataID = $(this).data('id');
            // alert(dataID);
            e.preventDefault();
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
        })
    })
</script>
</script>
@if($drivers->count())
<script>
    $(document).ready(function() {
        $('#driversTable').DataTable({
            responsive: true,
            stateSave: true,
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 0
                }, // ID
                {
                    responsivePriority: 1,
                    targets: 1
                }, // Name
                {
                    responsivePriority: 2,
                    targets: 5
                }, // Status
                {
                    responsivePriority: 3,
                    targets: 4
                }, // Truck Type
                {
                    responsivePriority: 4,
                    targets: 8
                } // Actions
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search...",
                emptyTable: "No drivers found matching the criteria."
            },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            pageLength: 10
        });
    });
</script>
@endif
@endpush