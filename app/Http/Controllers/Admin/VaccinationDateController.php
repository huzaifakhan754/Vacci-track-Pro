<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VaccinationSchedule;
use App\Models\Child;
use App\Models\Vaccine;
use App\Models\ParentRequest;
use Carbon\Carbon;
use Illuminate\View\View;

class VaccinationDateController extends Controller
{
    public function index(): View
    {
        // Aapka asli code safe rakha hai
        $schedules = VaccinationSchedule::with(['child.parent', 'vaccine'])
            ->where('scheduled_date', '>=', now()->toDateString())
            ->where('status', 'upcoming')
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->get();

        // 🔥 FIX: Saare bache aur unke requests ka direct data nikalen
        $allRequests = ParentRequest::with(['child.parent', 'vaccine'])->latest()->get();

        return view('admin.vaccination-dates.index', compact('schedules', 'allRequests'));
    }
}