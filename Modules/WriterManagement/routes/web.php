<?php

use Illuminate\Support\Facades\Route;
use Modules\WriterManagement\App\Http\Controllers\WriterManagementController;

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
    Route::group([], function () {
        Route::resource('writer-management', WriterManagementController::class)->names('writermanagement');
    });
    
    Route::post('writer-management/calculatePayment', [WriterManagementController::class, 'calculatePayment'])->name('writermanagement.calculatePayment');
    Route::get('writer-management/{id}/disable-enable-writer', [WriterManagementController::class, 'disableEnableWriter'])->name('writermanagement.disableEnableWriter');
    Route::get('writer-management/{writer_id}/view-language-maps', [WriterManagementController::class, 'viewLanguageMaps'])->name('writermanagement.viewLanguageMaps');
    Route::get('writer-management/{writer_id}/add-language-maps', [WriterManagementController::class, 'addLanguageMapView'])->name('writermanagement.addLanguageMapView');
    Route::post('writer-management/{writer_id}/add-language-maps', [WriterManagementController::class, 'addLanguageMap'])->name('writermanagement.addLanguageMap');
    Route::get('writer-management/{writer_id}/edit-language-maps/{id}', [WriterManagementController::class, 'editLanguageMap'])->name('writermanagement.editLanguageMap');
    Route::put('writer-management/{writer_id}/update-language-maps/{id}', [WriterManagementController::class, 'updateLanguageMap'])->name('writermanagement.updateLanguageMap');
    Route::get('writer-management/{writer_id}/delete-language-maps/{id}', [WriterManagementController::class, 'deleteLanguageMap'])->name('writermanagement.deleteLanguageMap');
    Route::get('writer-management/{writer_id}/view-payments', [WriterManagementController::class, 'viewPayments'])->name('writermanagement.viewPayments');
    Route::get('writer-management/{writer_id}/edit-payments/{id}', [WriterManagementController::class, 'editPaymentView'])->name('writermanagement.editPaymentView');
    Route::put('writer-management/{writer_id}/edit-payments/{id}', [WriterManagementController::class, 'editPayment'])->name('writermanagement.editPayment');
    Route::get('writer-management/{writer_id}/add-payments', [WriterManagementController::class, 'addPaymentView'])->name('writermanagement.addPaymentView');
    Route::post('writer-management/{writer_id}/add-payments', [WriterManagementController::class, 'addPayment'])->name('writermanagement.addPayment');
    Route::get('writer-management/{writer_id}/show-payments{id}', [WriterManagementController::class, 'showPayment'])->name('writermanagement.showPayment');
    
});

