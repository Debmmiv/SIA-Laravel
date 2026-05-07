<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['loan_id', 'customer_id', 'amount_paid', 'date_paid'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
