<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Company\App\Http\Controllers\V1\Admin\CompanyController;

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

Route::middleware(['auth:sanctum'])->name('api.v1.companies')->group(function () {
    Route::get('companies', [CompanyController::class, 'index']);
    Route::get('companies/{company}/contacts', [CompanyController::class, 'contacts'])->name('contacts');
});
