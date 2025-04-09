<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DriverRegistered;



class DriverController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function driversDashboard(Driver $driver)
    {

        return view('drivers.dashboard', compact('driver'));
    }

    public function showCheckForm()
    {
        return view('drivers.check');
    }


    public function checkStatus(Request $request)
    {
        $request->validate([
            'identifier' => 'required'
        ]);

        $driver = Driver::where('email', $request->identifier)
            ->orWhere('phone', $request->identifier)
            ->first();

        if (!$driver) {
            return back()->with('error', 'No registration found for the given email or phone number.');
        }

        return redirect()->route('drivers.dashboard', ['driver' => $driver->id]);
    }


    public function store(Request $request)
    {

        if ($request->honeypot) {
            return redirect()->back()->withErrors(['honeypot' => 'Bot detected!']);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:drivers,email',
            'phone' => 'required|digits:10', // Ensures the phone number is exactly 10 digits
            'truck_type' => 'required',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Store the document in the public storage

        $path = $request->file('document')->store('documents', 'public');


        // Create a new driver record
        $driver = Driver::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'truck_type' => $validated['truck_type'],
            'document_path' => $path,
        ]);

        // Send the confirmation email
        // Mail::to($driver->email)->send(new DriverRegistered($driver));


        // Redirect to the driver dashboard with the newly created driver ID
        return redirect()->route('drivers.dashboard', ['driver' => $driver->id]);
    }
}
