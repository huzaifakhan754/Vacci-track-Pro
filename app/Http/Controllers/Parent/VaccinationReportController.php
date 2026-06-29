<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\ParentRequest;
use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VaccinationReportController extends Controller
{
    /**
     * Index page jahan saare bacho ki reports ki list dikhegi
     */
    public function index(): View
    {
        // 1. Logged-in parent ke bache nikalen
        $myChildren = Child::where('parent_id', auth()->id())->get();

        // 2. Hum check karenge ke kis bache ka kam se kam ek request 'vaccinated' ho chuka hai
        $childIds = $myChildren->pluck('id')->toArray();
        
        // Sirf wahi bache dikhayenge jinka data reports table me show karne layaq ho
        $reports = ParentRequest::with(['child', 'vaccine', 'hospital'])
            ->whereIn('child_id', $childIds)
            ->where('status', 'vaccinated')
            ->latest()
            ->get();

        return view('parent.reports.index', compact('reports', 'myChildren'));
    }

    /**
     * 🔥 VIEW METHOD: Naye khubsoorat design me bache ki sari completed vaccines dikhane ke liye
     */
    public function viewPdf($id)
    {
        // 1. Pehle us specific request ko dhoonden jahan se click hua hai
        $currentRequest = ParentRequest::findOrFail($id);

        // Security Check: Pata karen bacha isi parent ka hai ya nahi
        $child = Child::where('id', $currentRequest->child_id)
            ->where('parent_id', auth()->id())
            ->firstOrFail();

        // 2. 🔥 MAIN LOGIC: Is bache ke SAARE 'vaccinated' records nikalen aik sath list me dikhane ke liye
        $allVaccines = ParentRequest::with(['vaccine', 'hospital'])
            ->where('child_id', $child->id)
            ->where('status', 'vaccinated')
            ->get();

        // View bhejte waqt bacha aur uski saari completed vaccines pass karenge
        return view('parent.reports.pdf', compact('child', 'allVaccines', 'currentRequest'));
    }

    /**
     * 🔥 DOWNLOAD METHOD: Force download (.html file ya dynamic view response)
     */
    public function download($id)
    {
        $currentRequest = ParentRequest::findOrFail($id);

        $child = Child::where('id', $currentRequest->child_id)
            ->where('parent_id', auth()->id())
            ->firstOrFail();

        $allVaccines = ParentRequest::with(['vaccine', 'hospital'])
            ->where('child_id', $child->id)
            ->where('status', 'vaccinated')
            ->get();

        $content = view('parent.reports.pdf', compact('child', 'allVaccines', 'currentRequest'))->render();
        
        return response($content)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="vaccination-report-'.$child->name.'.html"');
    }
}