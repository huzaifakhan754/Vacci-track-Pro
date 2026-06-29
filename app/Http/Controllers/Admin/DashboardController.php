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
        $upcomingVaccinations = VaccinationSchedule::where('scheduled_date', '>=', now()->toDateString())
            ->where('status', 'upcoming')
            ->count();
        $pendingRequests = ParentRequest::where('status', 'pending')->count();

        $recentSchedules = VaccinationSchedule::with(['child', 'vaccine'])
            ->where('scheduled_date', '>=', now()->toDateString())
            ->where('status', 'upcoming')
            ->orderBy('scheduled_date')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalChildren',
            'totalHospitals',
            'upcomingVaccinations',
            'pendingRequests',
            'recentSchedules',
        ));
    }
}
