<?php

use Illuminate\Support\Facades\Route;
use Modules\Contact\App\Http\Controllers\V1\Admin\ContactController;

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

Route::middleware(['auth:sanctum'])->name('api.v1.contacts')->group(function () {
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::post('/contact', [ContactController::class, 'store']);
    Route::patch('/{contact}/contact', [ContactController::class, 'update']);
    Route::get('/{contact}/contact', [ContactController::class, 'show']);
    Route::post('/companies/{company}/contacts', [ContactController::class, 'storeBulkForCompany']);
    Route::post('/contacts/{contact}/add-notes', [ContactController::class, 'addNotesToContact']);
});
