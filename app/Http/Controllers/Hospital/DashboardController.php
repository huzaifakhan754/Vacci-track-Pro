<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\ParentRequest; // 🔥 Model changed
use App\Models\Hospital;
use App\Models\Doctor;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
{
    $hospital = $this->resolveHospital();

    // Is hospital ka saara data uthayen
    $allRequests = ParentRequest::where('hospital_id', $hospital->id)->get();

    // 2. Pending Vaccinations (Jo approved hain par abhi vaccine nahi lagi)
    $pendingVaccinations = $allRequests->where('status', 'approved')->count();

    // 3. Completed / Vaccinated Card
    // 🔥 FIXED: 'Vaccinated' ko 'vaccinated' kiya taake real entries count hon
    $completedVaccinations = $allRequests->where('status', 'vaccinated')->count();

    $totalDoctors = Doctor::where('hospital_id', $hospital->id)->count();
    

    $recentAppointments = ParentRequest::with(['child.parent', 'vaccine'])
        ->where('hospital_id', $hospital->id)
        ->where('status', 'approved')
        ->latest()
        ->take(5)
        ->get();

    return view('hospital.dashboard', compact(
        'hospital',
        'pendingVaccinations',
        'completedVaccinations',
        'recentAppointments',
        'totalDoctors' 
    ));
}
    protected function resolveHospital(): Hospital
    {
        $user = auth()->user();
        if ($user->hospital) {
            return $user->hospital;
        }
        return Hospital::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'address' => 'Please update your address',
            'location' => 'Please update location',
            'phone' => '0000000000',
        ]);
    }
}
