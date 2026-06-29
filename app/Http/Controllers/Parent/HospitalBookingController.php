<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\ParentRequest;
use App\Models\Vaccine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HospitalBookingController extends Controller
{
    public function index(): View
    {
        $hospitals = Hospital::orderBy('name')->get();
        $children = auth()->user()->children()->orderBy('name')->get();
        $vaccines = Vaccine::where('is_available', true)->orderBy('name')->get();
        $requests = ParentRequest::with(['child', 'hospital', 'vaccine'])
            ->where('parent_id', auth()->id())
            ->latest()
            ->get();

        return view('parent.bookings.index', compact('hospitals', 'children', 'vaccines', 'requests'));
    }

    

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'child_id' => ['required', 'exists:children,id'],
            'hospital_id' => ['required', 'exists:hospitals,id'],
            'vaccine_id' => ['required', 'exists:vaccines,id'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $child = auth()->user()->children()->findOrFail($validated['child_id']);

        ParentRequest::create([
            'parent_id' => auth()->id(),
            'child_id' => $child->id,
            'hospital_id' => $validated['hospital_id'],
            'vaccine_id' => $validated['vaccine_id'],
            'preferred_date' => $validated['preferred_date'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('parent.bookings.index')
            ->with('success', 'Hospital appointment request submitted. Admin will approve or reject it.');
    }

    public function markAlreadyVaccinated(Request $request)
{
    $request->validate([
        'child_id' => 'required|exists:children,id',
        'vaccine_id' => 'required|exists:vaccines,id',
        'preferred_date' => 'required|date',
    ]);

    // Database me direct Completed record insert kar dena
    \App\Models\ParentRequest::create([
        'parent_id' => auth()->id(),
        'child_id' => $request->child_id,
        'vaccine_id' => $request->vaccine_id,
        'hospital_id' => null, // Kyunki kisi hospital se nahi lagwayi, khud mark kiya h
        'preferred_date' => $request->preferred_date,
        'status' => 'completed', // Direct completed!
        'message' => 'Marked as already vaccinated by parent.',
    ]);

    return redirect()->back()->with('success', 'Vaccine marked as completed and moved to history.');
}
}
