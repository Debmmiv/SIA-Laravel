<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $loans = Loan::query()
            ->when($search, function ($query, $search) {
                $query->where('description', 'like', "%{$search}%")
                      ->orWhere('amount', 'like', "%{$search}%");
            })
            ->paginate(5)
            ->appends(['search' => $search]);

        return view('loans.index', compact('loans', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('loans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'amount' => 'required|numeric',
            'term' => 'required|integer',
            'interest' => 'required|numeric',
            'dategranted' => 'required|date',
        ]);

        Loan::create($request->all());

        return redirect()->route('loans.index')->with('success', 'Loan added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        return view('loans.edit', compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'description' => 'required',
            'amount' => 'required|numeric',
            'term' => 'required|integer',
            'interest' => 'required|numeric',
            'dategranted' => 'required|date',
        ]);

        $loan->update($request->all());

        return redirect()->route('loans.index')->with('success', 'Loan updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully!');
    }
}
