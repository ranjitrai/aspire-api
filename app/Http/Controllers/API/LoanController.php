<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Loan;


class LoanController extends Controller
{
	/**
     * save apply loan data.
     *
     */
    public function store(Request $request)
    {

    	$user_id  = Auth::user()->id;
    	 $validatedData = $request->validate([
            'amount' => 'required',
            'term' => 'required',
        ]);

    	 $validatedData['user_id'] = $user_id;

    	 $loan = Loan::create($validatedData);

    	 if($loan) {
	    	 	$response = array(
	              "status" => true,
	              "message" => "Applied for loan successfully",
	              "data" => $loan
	            );
	    	 }else {
	    	 	$response = array(
	              "status" => false,
	              "message" => "something went wrong",
	              "data" => null
	            );
	    	 }

            return response()->json($response);
    }

    /**
     * Accept loan of users.
     *
     */
    public function acceptLoan(Request $request) {

    	$validatedData = $request->validate([
            'loan_id' => 'required',
        ]);
    	//update loans table column status as accepeted
    	$result = Loan::where('id',$request->loan_id)->update(['status' => config('loan-status.accepted')]);

    	if($result) {
	    	 	$response = array(
	              "status" => true,
	              "message" => "Loan Accepted Successfully",
	            );
	    	 }else {
	    	 	$response = array(
	              "status" => false,
	              "message" => "Something Went Wrong",
	            );
	    	 }

            return response()->json($response);
    }
}
