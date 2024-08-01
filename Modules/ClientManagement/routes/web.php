<?php

use Illuminate\Support\Facades\Route;
use Modules\ClientManagement\App\Http\Controllers\ClientManagementController;

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
    Route::resource('client-management', ClientManagementController::class)->names('clientmanagement');
    Route::get('client-management/{id}/add-contact', [ClientManagementController::class, 'addContactForm'])->name('clientmanagement.addContact');
    Route::post('client-management/{id}/add-contact', [ClientManagementController::class, 'storeContact'])->name('clientmanagement.storeContact');
    Route::get('client-management/{id}/edit-contact/{contact_id}', [ClientManagementController::class, 'editContactForm'])->name('clientmanagement.editContactForm');
    Route::put('client-management/{id}/edit-contact/{contact_id}', [ClientManagementController::class, 'editContact'])->name('clientmanagement.editContact');
    Route::get('client-management/{id}/view-contacts', [ClientManagementController::class, 'viewContacts'])->name('clientmanagement.viewContacts');
    Route::get('client-management/{id}/disable-enable-contact/{contact_id}', [ClientManagementController::class, 'disableEnableContact'])->name('clientmanagement.disableEnableContact');
    Route::get('client-management/{id}/delete-contact/{contact_id}', [ClientManagementController::class, 'deleteContact'])->name('clientmanagement.deleteContact');

    Route::get('client-management/{id}/disable-enable-client', [ClientManagementController::class, 'disableEnableClient'])->name('clientmanagement.disableEnableClient');

    // rate card
    Route::get('client-management/{id}/view-ratecards', [ClientManagementController::class, 'redirectToRatecardList'])->name('clientmanagement.redirectToRatecardList');
    Route::get('client-management/{id}/add-ratecard', [ClientManagementController::class, 'redirectToRatecardAdd'])->name('clientmanagement.redirectToRatecardAdd');
    Route::post('client-management/{id}/add-ratecard', [ClientManagementController::class, 'ratecardAdd'])->name('clientmanagement.ratecardAdd');
    Route::get('client-management/{id}/edit-ratecard/{ratecardId}', [ClientManagementController::class, 'redirectToRatecardEdit'])->name('clientmanagement.redirectToRatecardEdit');
    Route::put('client-management/{id}/edit-ratecard/{ratecardId}', [ClientManagementController::class, 'ratecardEdit'])->name('clientmanagement.ratecardEdit');
    Route::get('client-management/{id}/delete-ratecard/{ratecardId}', [ClientManagementController::class, 'ratecardDelete'])->name('clientmanagement.ratecardDelete');
});