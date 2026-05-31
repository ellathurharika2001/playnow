<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $privacyPolicies = PrivacyPolicy::latest()->paginate(10);

        return view('admin.privacy-policies.index', compact('privacyPolicies'));
    }

    public function create()
    {
        return view('admin.privacy-policies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        PrivacyPolicy::create($validated);

        return redirect()
            ->route('admin.privacy-policies.index')
            ->with('success', 'Privacy Policy created successfully.');
    }

    public function edit(PrivacyPolicy $privacyPolicy)
    {
        return view('admin.privacy-policies.edit', compact('privacyPolicy'));
    }

    public function update(Request $request, PrivacyPolicy $privacyPolicy)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $privacyPolicy->update($validated);

        return redirect()
            ->route('admin.privacy-policies.index')
            ->with('success', 'Privacy Policy updated successfully.');
    }

    public function destroy(PrivacyPolicy $privacyPolicy)
    {
        $privacyPolicy->delete();

        return redirect()
            ->route('admin.privacy-policies.index')
            ->with('success', 'Privacy Policy deleted successfully.');
    }
}