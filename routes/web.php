<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\LoanDetailsController;
use App\Http\Controllers\EmiDetailsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
    Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
    Route::get('/logout', [AdminAuthController::class, 'adminLogout'])->name('adminLogout');

    Route::group(['middleware' => 'adminauth'], function () {
        // Route::get('/dashboard', function () {
        //     return view('admin.dashboard');
        // })->name('adminDashboard');
        Route::get('/loandetails', [LoanDetailsController::class, 'index'])->name('get_loan_details');
        Route::get('/loandetails/{clientid}', [LoanDetailsController::class, 'getbyclient'])->name('get_loan_details_by_client');
        Route::get('/loanprocess', [LoanDetailsController::class, 'process'])->name('convert_emis');
        Route::get('/emidetails', [EmiDetailsController::class, 'index'])->name('get_emi_details');
    });
    
});

Route::get('/', function () {
    return view('welcome');
});
