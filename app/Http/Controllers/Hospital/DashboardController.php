<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\ParentRequest; // 🔥 Model changed
use App\Models\Hospital;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $hospital = $this->resolveHospital();

        // Is hospital ka saara data uthayen
        $allRequests = ParentRequest::where('hospital_id', $hospital->id)->get();

        // 1. Total Appointments (Approved, Vaccinated, Not Vaccinated sab mila kar)
        $totalAppointments = $allRequests->whereIn('status', ['approved', 'Vaccinated', 'Not Vaccinated'])->count();

        // 2. Pending Vaccinations (Jo admin se approved hain par abhi vaccine nahi lagi)
        $pendingVaccinations = $allRequests->where('status', 'approved')->count();

        // 3. Completed / Vaccinated
        $completedVaccinations = $allRequests->where('status', 'Vaccinated')->count();

        // Recent Appointments Table ke liye (Sirf approved wale jo abhi pending hain)
        $recentAppointments = ParentRequest::with(['child.parent', 'vaccine'])
            ->where('hospital_id', $hospital->id)
            ->where('status', 'approved')
            ->latest()
            ->take(5)
            ->get();

        return view('hospital.dashboard', compact(
            'hospital',
            'totalAppointments',
            'pendingVaccinations',
            'completedVaccinations',
            'recentAppointments'
        ));
    }

    protected function resolveHospital(): Hospital
    {
        $user = auth()->user();
        if ($user->hospital) { return $user->hospital; }
        return Hospital::create([
            'user_id' => $user->id, 'name' => $user->name, 'email' => $user->email,
            'address' => 'Please update your address', 'location' => 'Please update location', 'phone' => '0000000000',
        ]);
    }
}