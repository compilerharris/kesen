<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
Route::get('/', function () {
        return redirect('/home');
});
Route::get('/bill-report', [App\Http\Controllers\HomeController::class, 'showBillReportForm'])->name('billReport')->middleware('auth');
Route::post('/bill-report', [App\Http\Controllers\HomeController::class, 'generateBillReport'])->name('report.bills')->middleware('auth');
Route::get('/writer-report', [App\Http\Controllers\HomeController::class, 'showWriterReportForm'])->name('writerReport')->middleware('auth');
Route::post('/writer-report', [App\Http\Controllers\HomeController::class, 'generateWriterReport'])->name('report.writers')->middleware('auth');
Route::get('/payment-report', [App\Http\Controllers\HomeController::class, 'showPaymentlReportForm'])->name('paymentReport')->middleware('auth');
Route::post('/payment-report', [App\Http\Controllers\HomeController::class, 'generatePaymentReport'])->name('report.payments')->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/writer-workload-report', [App\Http\Controllers\HomeController::class, 'writerWorkloadRedirect'])->name('writerWorkloadRedirect')->middleware('auth');
Route::post('/writer-workload-report', [App\Http\Controllers\HomeController::class, 'writerWorkload'])->name('report.writerWorkload')->middleware('auth');
