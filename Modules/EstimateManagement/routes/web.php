<?php

use Illuminate\Support\Facades\Route;
use Modules\EstimateManagement\App\Http\Controllers\EstimateManagementController;

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
Route::resource('estimate-management', EstimateManagementController::class)->names('estimatemanagement');
Route::get('estimate-management/status/{id}/{status}', [EstimateManagementController::class, 'changeStatus'])->name('estimatemanagement.status');
Route::get('estimate-management/client/{id}', [EstimateManagementController::class, 'getContactPerson'])->name('estimatemanagement.client');
Route::get('estimate-management/estimate/{id}', [EstimateManagementController::class, 'getEstimateData'])->name('estimatemanagement.estimatedata');
Route::get('estimate-management/estimate-details/{id}', [EstimateManagementController::class, 'getEstimateDetails'])->name('estimatemanagement.estimatedetails');
Route::get('estimate-management/client/view-pdf/{id}', [EstimateManagementController::class, 'viewPdf'])->name('estimatemanagement.viewPdf');
Route::get('estimate-management/export/pdf', [EstimateManagementController::class, 'exportEstimate'])->name('estimatemanagement.exporteestimate');
Route::delete('estimate-management/detail/delete', [EstimateManagementController::class, 'deleteDetail'])->name('estimatemanagement.deleteDetail');
});

