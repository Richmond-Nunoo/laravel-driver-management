<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.index');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function dashboard(Request $request)
    {
        // Main query with filters
        $query = Driver::query()
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%");
                });
            })
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->when($request->truck_type, fn($q, $type) => $q->where('truck_type', $type));

        // Paginated drivers list
        $drivers = $query->latest()->paginate(10)->withQueryString();

        // Dashboard metrics
        $metrics = [
            'total' => Driver::count(),
            'today' => Driver::whereDate('created_at', today())->count(),
            'approved' => Driver::where('status', 'approved')->count(),
            'pending' => Driver::where('status', 'pending')->count(),
        ];

        // Prepare data for Google Pie Chart (Truck Type Distribution)
        $truckTypeData = Driver::select('truck_type')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('truck_type')
            ->get();

        $pieArray[] = ['Truck Type', 'Count'];
        foreach ($truckTypeData as $item) {
            $pieArray[] = [$item->truck_type, (int)$item->count];
        }

        // Prepare data for Google Line Chart (Registration Trends - Last 7 Days)
        $lineData = Driver::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereDate('created_at', '>=', Carbon::today()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $lineArray[] = ['Date', 'Registrations'];
        foreach (range(6, 0) as $i) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $displayDate = Carbon::today()->subDays($i)->format('M d');
            $count = $lineData->firstWhere('date', $date)->count ?? 0;
            $lineArray[] = [$displayDate, (int)$count];
        }

        return view('admin.index', [
            'drivers' => $drivers,
            'metrics' => $metrics,
            'truckTypes' => json_encode($pieArray),
            'registrationTrends' => json_encode($lineArray)
        ]);
    }

    // Keep your existing getRegistrationTrendData method
    protected function getRegistrationTrendData()
    {
        $data = Driver::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        $labels = [];
        $values = [];

        foreach (range(6, 0) as $i) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('M d');
            $values[] = $data[$date] ?? 0;
        }

        return ['labels' => $labels, 'data' => $values];
    }




    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function exportPdf()
    {
        $drivers = Driver::all();
        $pdf = Pdf::loadView('admin.exports.drivers', compact('drivers'));
        return $pdf->download('registered-drivers.pdf');
    }
}
