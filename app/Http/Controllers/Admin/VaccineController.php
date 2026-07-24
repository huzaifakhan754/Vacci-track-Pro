<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vaccine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class VaccineController extends Controller
{
    public function index(): View
    {
        $vaccines = Vaccine::all();

        return view('admin.vaccines.index', compact('vaccines'));
    }

    function insert(Request $req){
        vaccine::create($req->all());
        return Redirect()->route('admin.vaccines.index');
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
