<?php

use Illuminate\Support\Facades\Route;
use Modules\LanguageManagement\App\Http\Controllers\LanguageManagementController;

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
Route::resource('language-management', LanguageManagementController::class)->names('language-management');
Route::get('language-management/disable-enable-language/{id}', [LanguageManagementController::class, 'disableEnableClient'])->name('language-management.disableEnableClient');
});
