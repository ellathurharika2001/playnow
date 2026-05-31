<?php

namespace App\Http\Controllers;

use App\Models\TermsCondition;
use Illuminate\Http\Request;

class TermsConditionController extends Controller
{
    public function index()
    {
        $termsConditions = TermsCondition::latest()->paginate(10);

        return view('admin.terms-conditions.index', compact('termsConditions'));
    }

    public function create()
    {
        return view('admin.terms-conditions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        TermsCondition::create($validated);

        return redirect()
            ->route('admin.terms-conditions.index')
            ->with('success', 'Terms & Conditions created successfully.');
    }

    public function edit(TermsCondition $termsCondition)
    {
        return view('admin.terms-conditions.edit', compact('termsCondition'));
    }

    public function update(Request $request, TermsCondition $termsCondition)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $termsCondition->update($validated);

        return redirect()
            ->route('admin.terms-conditions.index')
            ->with('success', 'Terms & Conditions updated successfully.');
    }

    public function destroy(TermsCondition $termsCondition)
    {
        $termsCondition->delete();

        return redirect()
            ->route('admin.terms-conditions.index')
            ->with('success', 'Terms & Conditions deleted successfully.');
    }
}