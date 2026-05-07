<?php

namespace App\Http\Controllers;

use App\Models\LoanTransaction;
use App\Models\Customer;
use App\Models\Loan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LoanTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $transactions = LoanTransaction::with('customer', 'loan')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('loan', function ($q) use ($search) {
                    $q->where('description', 'like', "%{$search}%");
                });
            })
            ->paginate(5)
            ->appends(['search' => $search]);

        return view('loantransactions.index', compact('transactions', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $loans = Loan::all();
        return view('loantransactions.create', compact('customers', 'loans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'customer_id' => 'required|exists:customers,id',
            'amount_paid' => 'required|numeric',
            'date_paid' => 'required|date',
        ]);

        LoanTransaction::create($request->all());

        return redirect()->route('loantransactions.index')->with('success', 'Loan Transaction recorded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LoanTransaction $loantransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoanTransaction $loantransaction)
    {
        $customers = Customer::all();
        $loans = Loan::all();
        return view('loantransactions.edit', compact('loantransaction', 'customers', 'loans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoanTransaction $loantransaction)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'customer_id' => 'required|exists:customers,id',
            'amount_paid' => 'required|numeric',
            'date_paid' => 'required|date',
        ]);

        $loantransaction->update($request->all());

        return redirect()->route('loantransactions.index')->with('success', 'Loan Transaction updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoanTransaction $loantransaction)
    {
        $loantransaction->delete();

        return redirect()->route('loantransactions.index')->with('success', 'Loan Transaction deleted successfully!');
    }

    /**
     * Generate PDF report of loan transactions.
     */
    public function generatePDF(Request $request)
    {
        $search = $request->input('search');

        $transactions = LoanTransaction::with('customer', 'loan')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('loan', function ($q) use ($search) {
                    $q->where('description', 'like', "%{$search}%");
                });
            })
            ->get();

        $pdf = Pdf::loadView('loantransactions.pdf', compact('transactions', 'search'));

        return $pdf->download('loan-transactions-report.pdf');
    }
}
