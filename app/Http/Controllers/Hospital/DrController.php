<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor; // Apne Doctor model ka path check karlein

class DrController extends Controller
{
    // 1. Doctors ki list dikhane ke liye
    public function index()
    {
        // 1. Logged-in user ke hospital ka record nikalna
        $hospital = auth()->user()->hospital;

        // Agar hospital record nahi hai, to khali array bhej dein taake error na aaye
        if (!$hospital) {
            $doctors = collect();
        } else {
            // 2. Hospitals table ki actual ID se doctors fetch karein
            $doctors = Doctor::where('hospital_id', $hospital->id)->latest()->get();
        }

        return view('hospital.dr.index', compact('doctors'));
    }

    public function store(Request $request)
    {
        // 1. Validation checking
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'google_meet_link' => 'required|url',
        ]);

        // 🔥 Agat form se doctor_id aa rahi hai, to purane ko update karo (EDIT)
        if ($request->has('doctor_id') && $request->doctor_id != null) {

            $doctor = \App\Models\Doctor::findOrFail($request->doctor_id);
            $doctor->update([
                'name' => $request->name,
                'specialization' => $request->specialization,
                'google_meet_link' => $request->google_meet_link,
            ]);

            return redirect()->back()->with('success', 'Doctor updated successfully!');
        }

        // 🔥 Agar doctor_id nahi aa rahi, to naya add karo (ADD NEW)
        \App\Models\Doctor::create([
            'name' => $request->name,
            'specialization' => $request->specialization,
            'google_meet_link' => $request->google_meet_link,
            'hospital_id' => auth()->user()->hospital_id ?? 11, // Auto hospital mapping
            'is_online' => 0,
        ]);

        return redirect()->back()->with('success', 'New doctor added successfully!');
    }
    public function toggleStatus($id)
    {
        // 1. URL se aane wali ID ke mutabiq specific doctor dhoondein
        $doctor = \App\Models\Doctor::findOrFail($id);

        // 2. Agar status 1 hai to 0 kar do, agar 0 hai to 1 kar do
        $doctor->is_online = $doctor->is_online == 1 ? 0 : 1;
        $doctor->save();

        // 3. Page ko refresh kar do bina kisi error ke
        return redirect()->back()->with('success', 'Doctor status updated successfully!');
    }
    public function destroy($id)
{
    // 1. Doctor ko ID se dhoondein
    $doctor = \App\Models\Doctor::findOrFail($id);
    
    // 2. Database se delete marein
    $doctor->delete();

    // 3. Wapas bhej dein fresh success message ke sath
    return redirect()->back()->with('success', 'Doctor deleted successfully!');
}
}
