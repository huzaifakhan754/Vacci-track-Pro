<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParentRequest; // Ya jo bhi aapka model hai jisme history store hoti hai

class HistoryController extends Controller
{
    public function getDetails(Request $request)
    {
        // Hospital ki apni ID ke mutabiq complete/vaccinated bookings fetch karein
        $hospitalId = auth()->user()->id; 

        // Query aapke database structure ke mutabiq modify ho sakti hai
        // Hum un bookings ko la rahe hain jo completed hain ya updated hain
        $history = ParentRequest::with(['child', 'vaccine'])
            ->where('hospital_id', $hospitalId)
            ->where('status', 'vaccinated, rejected') // Ya 'completed' jo bhi aap status rakhte hain
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('hospital.history.vaccineHistory', compact('history'));
    }
}