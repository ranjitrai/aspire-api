<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Loan;
use App\UserLoanRepayment;


class LoanRepaymentController extends Controller
{
    
    /**
     * get amount which need to be repay.
     *
     */
    public function index($id) {
        	$user_id  = Auth::user()->id;
            $data['loan_id'] = $id;
            $result = Validator::make($data, [
                'loan_id' => ['required|exists:loans,id'],
            ]);

        	$loan_data = Loan::where('id',$id)
                            ->where('user_id',$user_id)
                            ->where('status',config('loan-status.accepted'))
                            ->where('is_loan_completed',false)
                            ->first();

           if(!empty($loan_data)) {
                $installment_number = UserLoanRepayment::where('loan_id',$id)->count();
                //1 month  4 weeks
                $number_of_weeks = ($loan_data->term * 4);
                $remaining_amount = $loan_data->amount;
                $amount_need_to_pay = ($remaining_amount/$number_of_weeks);
                $response = array(
                    "status" => true,
                    "amount" => round($amount_need_to_pay,2),
                    "loan_id" => $id,
                    "message" => "Amount to be paid"
                );
           }else {
                $response = array(
                    "status" => false,
                    "amount" => 00,
                    "loan_id" => $id,
                    "message" => "All installment paid"
                );
           }
                   
            return response()->json($response);
    }

    /**
     * Save user loan repayment data.
     *
     */
    public function store(Request $request){
        //authenticate user id
        $user_id  = Auth::user()->id;

        //validation
         $validated_data = $request->validate([
            'amount' => 'required',
            'loan_id' => 'required|exists:loans,id',
        ]);
        $validated_data['user_id'] = $user_id;

        //save repayment amount to user_loan_repayments table
        $repayment_data = UserLoanRepayment::create($validated_data);

        //check if user has paid all pending loan installment
        $is_all_installment_paid  = $this->checkAllInstallmentPaidOrNot($request->loan_id,$user_id);
        if($is_all_installment_paid) { // if all installment paid then change is_loan_completed column value to true
            Loan::where('id',$request->loan_id)->update(['is_loan_completed' => true]);
        }

         if($repayment_data) {
                $response = array(
                  "status" => true,
                  "message" => "Loan installment save successfully",
                  "data" => $repayment_data
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
     * function to check user has paid all loan installment or not.
     *
     */
    public function checkAllInstallmentPaidOrNot($loan_id,$user_id)
    {
        $loan_data = Loan::where('id',$loan_id)->where('user_id',$user_id)->where('status',config('loan-status.accepted'))->first();
        $installment_number = UserLoanRepayment::where('loan_id',$loan_id)->count();
        $number_of_weeks = ($loan_data->term * 4);
        if($installment_number  ==  $number_of_weeks){
            return true;
        }else {
            return false;
        }
    }
}
