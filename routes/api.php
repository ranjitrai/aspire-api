<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//register api for user who will apply for loan
Route::post('/register', 'Api\AuthController@register')->name('register');

//login api for users
Route::post('/login', 'Api\AuthController@login')->name('login');

//loan apply api for users
Route::post('/apply-loan', 'Api\LoanController@store')->middleware('auth:api')->name('apply.loan');

//accept loan
Route::post('/accept-loan', 'Api\LoanController@acceptLoan')->name('accept.loan');

//get user repayment amount
Route::get('/loan-repayment-amount/{id}', 'Api\LoanRepaymentController@index')->middleware('auth:api')->name('loan.repayment.amount');

//post user repayment
Route::post('/loan-repayment', 'Api\LoanRepaymentController@store')->middleware('auth:api')->name('loan.payment');
