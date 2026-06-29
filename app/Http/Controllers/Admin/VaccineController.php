<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vaccine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VaccineController extends Controller
{
    public function index(): View
    {
        $vaccines = Vaccine::orderBy('name')->get();

        return view('admin.vaccines.index', compact('vaccines'));
    }

    public function updateAvailability(Request $request, Vaccine $vaccine): RedirectResponse
    {
        $validated = $request->validate([
            'is_available' => ['required', 'boolean'],
        ]);

        $vaccine->update(['is_available' => $validated['is_available']]);

        $status = $vaccine->is_available ? 'available' : 'unavailable';

        return redirect()
            ->route('admin.vaccines.index')
            ->with('success', "Vaccine marked as {$status}.");
    }
}
