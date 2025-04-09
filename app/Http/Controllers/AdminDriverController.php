<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::latest()->get();
        return view('admin.drivers.index', compact('drivers'));
    }

    public function filter($status)
    {
        // Handle the different status filters
        switch ($status) {
            case 'today':
                $drivers = Driver::whereDate('created_at', now()->toDateString())->get();
                break;
            case 'approved':
                $drivers = Driver::where('status', 'approved')->get();
                break;
            case 'pending':
                $drivers = Driver::where('status', 'pending')->get();
                break;
            case 'rejected':
                $drivers = Driver::where('status', 'rejected')->get();
                break;
            case 'all':
            default:
                $drivers = Driver::latest()->get();  // Default to all drivers if no valid filter
        }

        // Pass the filtered drivers and the current status to the view
        return view('admin.drivers.index', compact('drivers', 'status'));
    }


    public function edit(Driver $driver)
    {
        return view('admin.drivers.edit', compact('driver'));
    }


    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:drivers,email,' . $driver->id,
            'phone' => 'required|string|max:10',
            'truck_type' => 'required|string|max:255',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status' => 'nullable|in:pending,approved,rejected',
        ]);

        $data = $request->only('full_name', 'email', 'phone', 'truck_type', 'status');

        // Handle document upload if provided
        if ($request->hasFile('document')) {
            // Delete old document if exists
            if ($driver->document_path && Storage::exists('public/documents/' . $driver->document_path)) {
                Storage::delete('public/documents/' . $driver->document_path);
            }

            // Store the new document
            $documentPath = $request->file('document')->store('public/documents');
            $data['document_path'] = basename($documentPath);
        }

        // Update the driver with new data
        $driver->update($data);

        return redirect()->route('admin.drivers.index')->with('success', 'Driver updated successfully.');
    }


    public function add(Driver $driver)
    {
        return view('admin.drivers.create', compact('driver'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:drivers,email',
            'phone' => 'required|string|max:10',
            'truck_type' => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Handle the document upload
        $path = $request->file('document')->store('documents', 'public');

        // Create the driver
        $driver = Driver::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'truck_type' => $validated['truck_type'],
            'document_path' => basename($path),
        ]);

        // Redirect to the driver dashboard or another page
        return redirect()->route('admin.drivers.index')->with('success', 'Driver added successfully.');
    }

    public function updateStatus(Request $request, Driver $driver)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $driver->update(['status' => $request->status]);

        return back()->with('success', 'Driver status updated.');
    }



    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();

        return redirect()->back()->with('success', 'Driver deleted successfully.');
    }
}
