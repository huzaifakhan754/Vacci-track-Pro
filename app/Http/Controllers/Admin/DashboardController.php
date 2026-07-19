<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Hospital;
use App\Models\ParentRequest;
use App\Models\VaccinationSchedule;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalChildren = Child::count();
        $totalHospitals = Hospital::count();
        $upcomingVaccinations = ParentRequest::where('status', 'approved')->count();
        $pendingRequests = ParentRequest::where('status', 'pending')->count();
        $recentSchedules = ParentRequest::all();

       $allRequests = ParentRequest::with(['child.parent', 'vaccine'])
        ->latest()
        ->get();

        return view('admin.dashboard', compact(
            'totalChildren',
            'totalHospitals',
            'upcomingVaccinations',
            'pendingRequests',
            'recentSchedules',
            'allRequests',
        ));
    }
}
