<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentRequest; // 🔥 Yeh model zaroor import karein
use Illuminate\Http\Request;
use Illuminate\View\View;

class VaccinationReportController extends Controller
{
    public function index(Request $request): View
    {
        $date = $request->input('date');

        // 🔥 ParentRequest se sirf 'vaccinated' status wala data nikalenge
        $reports = ParentRequest::with(['child.parent', 'vaccine', 'hospital'])
            ->where('status', 'vaccinated')
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('updated_at', $date); // Vaccinated date wise filter
            })
            ->orderByDesc('updated_at') // Jo abhi vaccinate huwa wo sabse upar dikhe
            ->get();

        return view('admin.reports.index', compact('reports', 'date'));
    }
}