<?php

namespace App\Http\Controllers\Parent;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Hospital;
use App\Models\vaccine;
use App\Models\ParentRequest;
use App\Models\VaccinationSchedule;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $parent = auth()->user();
        $childIds = $parent->children()->pluck('id');

        $totalChildren = $childIds->count();
        $upcomingVaccinations = VaccinationSchedule::whereIn('child_id', $childIds)
            ->where('scheduled_date', '>=', now()->toDateString())
            ->where('status', 'upcoming')
            ->count();
        $pendingRequests = ParentRequest::where('parent_id', $parent->id)
            ->where('status', 'pending')
            ->count();

        $recentSchedules = VaccinationSchedule::with(['child', 'vaccine'])
            ->whereIn('child_id', $childIds)
            ->where('scheduled_date', '>=', now()->toDateString())
            ->where('status', 'upcoming')
            ->orderBy('scheduled_date')
            ->limit(10)
            ->get();

        // my code 

        // 1. Logged-in parent ke bache nikalen (Fazool lines hata di hain)
        $myChildren = Child::where('parent_id', auth()->id())->get();
 
        // Dashboard stats ke liye count
        $childCount = $myChildren->count();
        $hospital = Hospital::all();

        $loggedInParentChildNames = $myChildren->pluck('name')->toArray();
        $appointments = VaccinationSchedule::whereIn('child_id', $loggedInParentChildNames)->latest()->get();

        // 2. Automatic Vaccination Schedule Loop
        $upcomingVaccines = [];
        $scheduleTemplate = [
            ['name' => 'BCG (Tuberculosis)', 'days_after_birth' => 0],
            ['name' => 'Polio Booster - Dose 1', 'days_after_birth' => 42],
            ['name' => 'Pentavalent - Dose 1', 'days_after_birth' => 42],
            ['name' => 'Measles - Dose 1', 'days_after_birth' => 270],
        ];

        $today = Carbon::now()->startOfDay();

        foreach ($myChildren as $child) {
            $birthDate = Carbon::parse($child->dob)->startOfDay();

            foreach ($scheduleTemplate as $vaccine) {
                $dueDate = $birthDate->copy()->addDays($vaccine['days_after_birth']);
                $daysLeft = $today->diffInDays($dueDate, false);

                // 🔥 Code me hi name match karne ke liye hum vaccine table se connect kar rahe hain
                $alreadyBooked = VaccinationSchedule::where('child_id', $child->id)
                    ->whereHas('vaccine', function ($query) use ($vaccine) {
                        $query->where('name', $vaccine['name']);
                    })
                    ->exists();

                if (!$alreadyBooked) {
                    // Vaccine ki ID find karne ke liye query (bache ke registration ke liye)
                    $dbVaccine = Vaccine::where('name', $vaccine['name'])->first();

                    $upcomingVaccines[] = [
                        'child_id'     => $child->id,
                        'child_name'   => $child->name,
                        'vaccine_id'   => $dbVaccine ? $dbVaccine->id : null,
                        'vaccine_name' => $vaccine['name'],
                        'due_date'     => $dueDate->format('M d, Y l'),
                        'days_left'    => $daysLeft
                    ];
                }
            }
        }

        $totalUpcomingCount = count($upcomingVaccines);
        $recentBookings = VaccinationSchedule::whereIn('child_name', $loggedInParentChildNames)
            ->latest()
            ->take(5)
            ->get();

            $upcomingVaccinations = collect($upcomingVaccines)->where('days_left', '>', 0)->count();
        return view('parent.dashboard', compact(
            'totalChildren',
            'upcomingVaccinations',
            'pendingRequests',
            'recentSchedules',
            'myChildren',
            'upcomingVaccines',
            'totalUpcomingCount',
            'recentBookings',
            'appointments',
            'hospital',            
        ));
    }
}



