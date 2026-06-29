<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Child;
use Illuminate\View\View;

class ChildController extends Controller
{
    public function index(): View
    {
        $children = Child::with('parent')
            ->latest()
            ->get();

        return view('admin.children.index', compact('children'));
    }

    public function show(Child $child): View
    {
        $child->load(['parent', 'vaccinationSchedules.vaccine', 'bookings.hospital', 'bookings.vaccine']);

        return view('admin.children.show', compact('child'));
    }
}
