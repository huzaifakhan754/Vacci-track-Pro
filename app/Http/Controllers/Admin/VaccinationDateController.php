<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentRequest;
use Illuminate\View\View;

class VaccinationDateController extends Controller
{
    public function index(): View
    {
        // 1. Purana fuzool code delete kar diya h
        // 2. Sirf 'vaccinated' aur 'rejected' status wala data load hoga
        $allRequests = ParentRequest::with(['child.parent', 'vaccine'])
            ->whereIn('status', ['approved', 'rejected']) 
            ->latest()
            ->get();

        return view('admin.vaccination-dates.index', compact('allRequests'));
    }
}