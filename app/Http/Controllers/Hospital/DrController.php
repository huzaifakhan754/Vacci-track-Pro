<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Validation\Rule;

class DrController extends Controller
{
    // Doctors List
    public function index()
    {
        $hospital = auth()->user()->hospital;

        if (!$hospital) {
            $doctors = collect();
        } else {
            $doctors = Doctor::where('hospital_id', $hospital->id)
                ->latest()
                ->get();
        }

        return view('hospital.dr.index', compact('doctors'));
    }

    // Add / Update Doctor
    public function store(Request $request)
    {
        // UPDATE
        if ($request->filled('doctor_id')) {

            $doctor = Doctor::findOrFail($request->doctor_id);

            $request->validate([
                'name' => 'required|string|max:255',
                'specialization' => 'required|string|max:255',
                'google_meet_link' => 'required|url',
                'phone' => [
                    'required',
                    Rule::unique('doctors', 'phone')->ignore($doctor->id),
                ],
            ]);

            $doctor->update([
                'name' => $request->name,
                'specialization' => $request->specialization,
                'google_meet_link' => $request->google_meet_link,
                'phone' => $request->phone,
            ]);

            return back()->with('success', 'Doctor updated successfully!');
        }

        // CREATE
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'google_meet_link' => 'required|url',
            'phone' => 'required|unique:doctors,phone',
        ]);

        $hospital = auth()->user()->hospital;

        if (!$hospital) {
            return back()->with('error', 'Hospital not found for this user.');
        }

        Doctor::create([
            'name' => $request->name,
            'specialization' => $request->specialization,
            'google_meet_link' => $request->google_meet_link,
            'phone' => $request->phone,
            'hospital_id' => $hospital->id,
            'is_online' => 0,
        ]);

        return back()->with('success', 'New doctor added successfully!');
    }

    // Toggle Status
    public function toggleStatus($id)
    {
        $doctor = Doctor::findOrFail($id);

        $doctor->is_online = !$doctor->is_online;
        $doctor->save();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_online' => $doctor->is_online,
                'message' => 'Doctor status updated successfully!',
            ]);
        }

        return back()->with('success', 'Doctor status updated successfully!');
    }

    // Delete Doctor
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return back()->with('success', 'Doctor deleted successfully!');
    }
}