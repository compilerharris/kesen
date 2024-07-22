<?php

use Illuminate\Support\Facades\Route;
use Modules\JobRegisterManagement\App\Http\Controllers\JobRegisterManagementController;

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

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('job-register-management/sent-letter/{id}', [JobRegisterManagementController::class, 'sendFeedBackForm'])->name('jobregistermanagement.sendFeedBackForm');
    Route::resource('job-register-management', JobRegisterManagementController::class)->names('jobregistermanagement');
    Route::get('job-register-management/pdf/{id}', [JobRegisterManagementController::class, 'viewPdf'])->name('jobregistermanagement.pdf');
    Route::get('job-register-management/complete/{id}', [JobRegisterManagementController::class, 'sendComplete'])->name('jobregistermanagement.complete');
    Route::get('job-register-management/excell/{id}', [JobRegisterManagementController::class, 'generateExcel'])->name('jobregistermanagement.excell');
});
