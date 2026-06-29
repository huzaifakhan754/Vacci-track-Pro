<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HospitalController extends Controller
{
    public function index(): View
    {
        $hospitals = Hospital::latest()->get();

        return view('admin.hospitals.index', compact('hospitals'));
    }

    public function create(): View
    {
        return view('admin.hospitals.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        Hospital::create($validated);

        return redirect()
            ->route('admin.hospitals.index')
            ->with('success', 'Hospital added successfully.');
    }

    public function edit(Hospital $hospital): View
    {
        return view('admin.hospitals.edit', compact('hospital'));
    }

    public function update(Request $request, Hospital $hospital): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $hospital->update($validated);

        return redirect()
            ->route('admin.hospitals.index')
            ->with('success', 'Hospital updated successfully.');
    }

    public function destroy(Hospital $hospital): RedirectResponse
    {
        $hospital->delete();

        return redirect()
            ->route('admin.hospitals.index')
            ->with('success', 'Hospital deleted successfully.');
    }
}
