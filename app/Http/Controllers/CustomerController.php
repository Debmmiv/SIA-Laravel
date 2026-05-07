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
     * RBAC: Admin only.
     */
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can add customers.');
        }

        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     * RBAC: Admin only.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can create customers.');
        }

        $request->validate([
            'name'    => 'required',
            'address' => 'required',
            'gender'  => 'required',
            'dob'     => 'required|date',
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
     * RBAC: Admin and Staff only.
     */
    public function edit(Customer $customer)
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            abort(403, 'Unauthorized. Only admins and staff can edit customers.');
        }

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     * RBAC: Admin and Staff only.
     */
    public function update(Request $request, Customer $customer)
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            abort(403, 'Unauthorized. Only admins and staff can update customers.');
        }

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * RBAC: Admin only.
     */
    public function destroy(Customer $customer)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can delete customers.');
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
    }

    /**
     * Export customer records to PDF.
     * RBAC: Admin only.
     */
    public function exportPdf(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can export PDF reports.');
        }
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
