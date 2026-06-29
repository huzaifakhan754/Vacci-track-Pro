<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Child;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChildController extends Controller
{
    public function index(): View
    {
        $children = auth()->user()->children()->latest()->get();

        return view('parent.children.index', compact('children'));
    }

    public function create(): View
    {
        return view('parent.children.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before_or_equal:today'],
            'gender' => ['required', 'in:male,female,other'],
            'blood_group' => ['nullable', 'string', 'max:10'],
        ]);

        auth()->user()->children()->create($validated);

        return redirect()
            ->route('parent.children.index')
            ->with('success', 'Child added successfully.');
    }

    public function edit(Child $child): View
    {
        $this->authorizeChild($child);

        return view('parent.children.edit', compact('child'));
    }

    public function update(Request $request, Child $child): RedirectResponse
    {
        $this->authorizeChild($child);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before_or_equal:today'],
            'gender' => ['required', 'in:male,female,other'],
            'blood_group' => ['nullable', 'string', 'max:10'],
        ]);

        $child->update($validated);

        return redirect()
            ->route('parent.children.index')
            ->with('success', 'Child details updated successfully.');
    }

    public function destroy(Child $child): RedirectResponse
    {
        $this->authorizeChild($child);

        $child->delete();

        return redirect()
            ->route('parent.children.index')
            ->with('success', 'Child removed successfully.');
    }

    private function authorizeChild(Child $child): void
    {
        if ($child->parent_id !== auth()->id()) {
            abort(403);
        }
    }
}
