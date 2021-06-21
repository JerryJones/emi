<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\LoanDetailController;
use App\Http\Controllers\EmiDetailController;

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

// Route::get('/', function () {
//     return view('dashboard');
// });
Route::get('/', [UserAuthController::class, 'index']); 

Route::get('dashboard', [UserAuthController::class, 'dashboard']); 
Route::get('login', [UserAuthController::class, 'index'])->name('login');
Route::post('authenticate', [UserAuthController::class, 'authenticate'])->name('authenticate'); 
Route::get('signout', [UserAuthController::class, 'signOut'])->name('signout');

Route::get('loandetails', [LoanDetailController::class, 'index'])->name('loandetails'); 

Route::get('emidetails', [EmiDetailController::class, 'index'])->name('emidetails'); 
Route::get('emidetails/processdata', [EmiDetailController::class, 'processData'])->name('processdata'); 