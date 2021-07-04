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

Route::namespace('API')->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('register', 'UsersController@register');
        Route::post('login', 'UsersController@login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('loans')->group(function () {
            Route::post('apply', 'LoansController@applyForLoan');
            Route::post('approve', 'LoansController@approveLoan');
            Route::get('details/{ref_no}', 'LoansController@loanDetails');
            Route::get('/', 'LoansController@getLoans');
            Route::post('repay', 'LoansController@repayLoan');
        });
    });
});
