<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FooterController extends Controller
{
    public function index()
    {
        $footers = Footer::latest()->paginate(10);

        return view('admin.footers.index', compact('footers'));
    }

    public function create()
    {
        return view('admin.footers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'footer_content' => 'required|string',
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',

            'facebook_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'linkedin_link' => 'nullable|url|max:255',

            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('footer_logo')) {
            $validated['footer_logo'] = $request->file('footer_logo')
                ->store('footers', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Footer::create($validated);

        return redirect()
            ->route('admin.footers.index')
            ->with('success', 'Footer created successfully.');
    }

    public function edit(Footer $footer)
    {
        return view('admin.footers.edit', compact('footer'));
    }

    public function update(Request $request, Footer $footer)
    {
        $validated = $request->validate([
            'footer_content' => 'required|string',
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',

            'facebook_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'linkedin_link' => 'nullable|url|max:255',

            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('footer_logo')) {

            if ($footer->footer_logo) {
                Storage::disk('public')->delete($footer->footer_logo);
            }

            $validated['footer_logo'] = $request->file('footer_logo')
                ->store('footers', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $footer->update($validated);

        return redirect()
            ->route('admin.footers.index')
            ->with('success', 'Footer updated successfully.');
    }

    public function destroy(Footer $footer)
    {
        if ($footer->footer_logo) {
            Storage::disk('public')->delete($footer->footer_logo);
        }

        $footer->delete();

        return redirect()
            ->route('admin.footers.index')
            ->with('success', 'Footer deleted successfully.');
    }
}