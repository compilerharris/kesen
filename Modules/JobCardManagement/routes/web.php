<?php

use Illuminate\Support\Facades\Route;
use Modules\JobCardManagement\App\Http\Controllers\JobCardManagementController;

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
Route::resource('job-card-management', JobCardManagementController::class)->names('jobcardmanagement');
});
Route::get('job-card-management/manage/{job_id}', [JobCardManagementController::class, 'manage'])->name('jobcardmanagement.manage');
Route::get('job-card-management/pdf/{job_id}', [JobCardManagementController::class, 'viewPdf'])->name('jobcardmanagement.pdf');
Route::get('job-card-management/manage/add/{job_id}/{estimate_detail_id}', [JobCardManagementController::class, 'create'])->name('jobcardmanagement.manage.add');
Route::get('job-card-management/manage/list/{job_id}/{estimate_detail_id}', [JobCardManagementController::class, 'listEstimateDetailsLanguage'])->name('jobcardmanagement.manage.list');
Route::delete('job-card-management/manage/delete/{manage_id}', [JobCardManagementController::class, 'manageDelete'])->name('jobcardmanagement.manage.delete');
Route::get('job-card-management/client/{client_id}', [JobCardManagementController::class, 'getEstimateNo'])->name('jobcardmanagement.estimate');
Route::get('job-card-management/bill/{job_id}', [JobCardManagementController::class, 'billForm'])->name('jobcardmanagement.bill');
Route::post('job-card-management/bill/{job_id}', [JobCardManagementController::class, 'addBill'])->name('jobcardmanagement.bill.store');
Route::put('job-card-management/bill/{job_id}', [JobCardManagementController::class, 'updateBill'])->name('jobcardmanagement.bill.update');
Route::get('job-card-management/status/{id}/{status}', [JobCardManagementController::class, 'changeStatus'])->name('jobcardmanagement.status');
Route::get('job-card-management/export/pdf', [JobCardManagementController::class, 'exportJobCard'])->name('jobcardmanagement.exportJobCard');