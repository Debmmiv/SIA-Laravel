<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all customers from the database
        $customers = \App\Models\Customer::all(); 
        
        // Pass the $customers variable to the view
        return view('customers.index', compact('customers'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
        'name' => 'required',
        'address' => 'required',
        'gender' => 'required',
        'dob' => 'required|date',
    ]);

    \App\Models\Customer::create($request->all());

    return redirect()->route('customers.index')->with('success', 'Customer added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
       $customer->update($request->all());

    return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

    // 2. THIS IS THE MISSING PART: Tell the browser to go back to the list
    return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
    }
}
