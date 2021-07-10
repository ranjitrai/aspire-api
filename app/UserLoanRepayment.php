<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLoanRepayment extends Model
{
	protected $fillable = [
        'user_id','loan_id','amount'
    ];
}
