<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdmincustomersController extends Controller
{
    /**
     * Display all customers
     */
    public function index()
    {
        $customers = customers::latest()->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.customers.form', [
            'customer' => new customers()
        ]);
    }

    /**
     * Store customer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email',
            'mobile' => 'nullable|string|unique:customers,mobile',
            'password' => 'required|min:6',
            'google_id' => 'nullable|string',
            'is_email_verified' => 'nullable|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        customers::create($validated);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Show single customer
     */
    public function show(customers $customer)
    {
        return view('admin.customers.show', [
            'customer' => $customer
        ]);
    }

    /**
     * Show edit form
     */
    public function edit(customers $customer)
    {
        return view('admin.customers.form', [
            'customer' => $customer
        ]);
    }

    /**
     * Update customer
     */
    public function update(Request $request, customers $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'mobile' => 'nullable|string|unique:customers,mobile,' . $customer->id,
            'password' => 'nullable|min:6',
            'google_id' => 'nullable|string',
            'is_email_verified' => 'nullable|boolean',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $customer->update($validated);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Delete customer
     */
    public function destroy(customers $customer)
    {
        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}