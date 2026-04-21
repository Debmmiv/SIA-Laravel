<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $customers = Customer::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%")
                      ->orWhere('gender', 'like', "%{$search}%");
            })
            ->paginate(5)
            ->appends(['search' => $search]);

        return view('customers.index', compact('customers', 'search'));
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

    /**
     * Export customer records to PDF.
     */
    public function exportPdf(Request $request)
    {
        $search = $request->input('search');

        $customers = Customer::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%")
                      ->orWhere('gender', 'like', "%{$search}%");
            })
            ->get();

        $pdf = Pdf::loadView('customers.pdf', compact('customers', 'search'));

        return $pdf->download('customers-report.pdf');
    }
}
