<?php

namespace App\Http\Controllers\Parent;

use Carbon\Carbon;
use App\Models\Child;
use App\Models\Hospital;
use App\Models\Vaccine;
use App\Models\ParentRequest; // Yeh model use hoga ab
use App\Http\Controllers\Controller;
use App\Models\VaccinationSchedule;
use Illuminate\View\View;

class VaccinationDateController extends Controller
{
    public function index(): View
    {
        // 1. Logged-in parent ke bache nikalen
        $myChildren = Child::where('parent_id', auth()->id())->get();
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

                // Vaccine ki ID find karna query ke liye
                $dbVaccine = Vaccine::where('name', $vaccine['name'])->first();
                $vaccineId = $dbVaccine ? $dbVaccine->id : null;

                // 🔥 CRITICAL FIX: Ab completed, vaccinated, aur not_vaccinated teeno status check honge
                $isCompleted = false;
                if ($vaccineId) {
                    $isCompleted = ParentRequest::where('child_id', $child->id)
                        ->where('vaccine_id', $vaccineId)
                        ->whereIn('status', ['completed', 'vaccinated', 'not_vaccinated']) // 👈 Yeh line badli h taake record gaib ho sake
                        ->exists();
                }

                // 🚫 Agar completed/vaccinated/not_vaccinated nahi hai, sirf tabhi list me aayega
                if (!$isCompleted) {
                    $upcomingVaccines[] = [
                        'child_id'     => $child->id,
                        'child_name'   => $child->name,
                        'vaccine_id'   => $vaccineId,
                        'vaccine_name' => $vaccine['name'],
                        'due_date'     => $dueDate->format('Y-m-d'), 
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

        return view('parent.vaccination-dates.index', compact(
            'myChildren',
            'upcomingVaccines',
            'totalUpcomingCount',
            'recentBookings',
            'appointments',
            'hospital',
        ));
    }
}