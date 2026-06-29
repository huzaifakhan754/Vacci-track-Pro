<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\ParentRequest; 
use App\Models\Hospital;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index(): View
    {
        // 1. Pehle pata karo ke kaunsa hospital login hai
        $hospital = $this->resolveHospital();

        // 2. 🔥 STRICT FILTER: Sirf is login hospital ka data aayega AUR sirf 'approved' status wala aayega
        $appointments = ParentRequest::with(['child.parent', 'vaccine'])
            ->where('hospital_id', $hospital->id) // 👈 Kisi aur hospital ka data bilkul nahi aayega
            ->where('status', 'approved')         // 👈 Sirf approved bache list me dikhenge
            ->latest()
            ->get();

        return view('hospital.appointments.index', compact('appointments', 'hospital'));
    }

    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $hospital = $this->resolveHospital();
        
        // Security check ke request exist karti hai aur isi hospital ki hai
        $booking = ParentRequest::findOrFail($id);

        if ($booking->hospital_id !== $hospital->id) {
            abort(403);
        }

        // Validation choti ABC (lowercase) accept karegi
        $validated = $request->validate([
            'vaccination_status' => ['required', 'in:vaccinated,not_vaccinated'],
        ]);

        $newStatus = $validated['vaccination_status'];

        // 🔥 DATABASE UPDATE: Status direct 'vaccinated' ya 'not_vaccinated' ho jayega
        DB::table('parent_requests')
            ->where('id', $id)
            ->update([
                'status' => $newStatus, 
                'updated_at' => now()
            ]);

        // Kyunki status ab 'approved' nahi raha, isliye page refresh hote hi row automatic gaib ho jayegi!
        return back()->with('success', 'Status updated and row processed successfully!');
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