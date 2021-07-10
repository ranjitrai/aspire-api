<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
	protected $fillable = [
        'user_id','amount','term','status','is_loan_completed'
    ];
}
