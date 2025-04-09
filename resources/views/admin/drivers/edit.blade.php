@extends('admin.layouts.master')

@section('main-content')
<div class="container py-4">
    <h4 class="mb-4 fw-bold text-primary">Edit Driver</h4>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">

            <form action="{{ route('admin.drivers.update', $driver->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $driver->full_name) }}"
                            class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $driver->email) }}" class="form-control"
                            required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" value="{{ old('phon1e', $driver->phone) }}" class="form-control"
                            maxlength="10" required>
                    </div>

                    <div class="col-md-6">
                        <label for="truck_type" class="form-label">Truck Type</label>
                        <select name="truck_type" class="form-select" required>
                            <option value="">Select Truck Type</option>
                            <option value="Tipper"
                                {{ old('truck_type', $driver->truck_type) == 'Tipper' ? 'selected' : '' }}>Tipper
                            </option>
                            <option value="Flatbed"
                                {{ old('truck_type', $driver->truck_type) == 'Flatbed' ? 'selected' : '' }}>Flatbed
                            </option>
                            <option value="Tanker"
                                {{ old('truck_type', $driver->truck_type) == 'Tanker' ? 'selected' : '' }}>Tanker
                            </option>
                            <option value="Container Carrier"
                                {{ old('truck_type', $driver->truck_type) == 'Container Carrier' ? 'selected' : '' }}>
                                Container Carrier</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="document" class="form-label">Document (PDF, JPG, PNG)</label>
                    <input type="file" name="document" class="form-control">
                    @if ($driver->document_path)
                    <small class="text-muted">Current:
                        <a href="{{ asset('storage/documents/' . $driver->document_path) }}" target="_blank">
                            View Document
                        </a>
                    </small>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="pending" {{ old('status', $driver->status) == 'pending' ? 'selected' : '' }}>
                            Pending</option>
                        <option value="approved" {{ old('status', $driver->status) == 'approved' ? 'selected' : '' }}>
                            Approved</option>
                        <option value="rejected" {{ old('status', $driver->status) == 'rejected' ? 'selected' : '' }}>
                            Rejected</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-1"></i> Update
                    </button>
                    <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
