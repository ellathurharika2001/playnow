<?php

namespace App\Http\Controllers;

use App\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeaderController extends Controller
{
    public function index()
    {
        $headers = Header::latest()->paginate(10);
        return view('admin.headers.index', compact('headers'));
    }

    public function create()
    {
        return view('admin.headers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'website_title' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'facebook_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'linkedin_link' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {

            $image = $request->file('logo');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('headers'), $imageName);

            $validated['logo'] = 'headers/' . $imageName;
        }

        $validated['is_active'] = $request->has('is_active');

        Header::create($validated);

        return redirect()->route('admin.headers.index')
            ->with('success', 'Header created successfully.');
    }

    public function edit(Header $header)
    {
        return view('admin.headers.edit', compact('header'));
    }

    public function update(Request $request, Header $header)
    {
        $validated = $request->validate([
            'website_title' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'facebook_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'linkedin_link' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {

            // Delete old logo
            if ($header->logo && file_exists(public_path($header->logo))) {

                unlink(public_path($header->logo));
            }

            $image = $request->file('logo');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('headers'), $imageName);

            $validated['logo'] = 'headers/' . $imageName;
        }

        $validated['is_active'] = $request->has('is_active');

        $header->update($validated);

        return redirect()->route('admin.headers.index')
            ->with('success', 'Header updated successfully.');
    }

    public function destroy(Header $header)
    {
        if ($header->logo) {
            Storage::disk('public')->delete($header->logo);
        }

        $header->delete();

        return redirect()->route('admin.headers.index')
            ->with('success', 'Header deleted successfully.');
    }
}