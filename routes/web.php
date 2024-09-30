<?php

use App\Http\Controllers\RequestController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\ReportController; // Import ReportController

Route::get('/', function () {
    return view('welcome');
});

// Routes for authentication
require __DIR__.'/auth.php';

// Route for the dashboard, accessible only to authenticated users
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Routes for the request system
Route::middleware('auth')->group(function () {
    Route::get('/request/create', [RequestController::class, 'create'])->name('request.create');
    Route::post('/request/store', [RequestController::class, 'store'])->name('request.store');
    Route::get('/requests', [RequestController::class, 'index'])->name('request.index');

    // Route to show a specific request
    Route::get('/request/{id}', [RequestController::class, 'show'])->name('request.show');
    // Route to edit a specific request
    Route::get('/request/{id}/edit', [RequestController::class, 'edit'])->name('request.edit');
    Route::put('/request/{id}', [RequestController::class, 'update'])->name('request.update');
    Route::delete('/request/{id}', [RequestController::class, 'destroy'])->name('request.destroy');
    Route::patch('/request/{id}/status', [RequestController::class, 'updateStatus'])->name('request.updateStatus');

    // Routes for the issue system
    Route::get('/issues', [IssueController::class, 'index'])->name('issues.index');
    Route::get('/issues/create', [IssueController::class, 'create'])->name('issues.create');
    Route::post('/issues', [IssueController::class, 'store'])->name('issues.store');
    Route::get('/issues/{issue}', [IssueController::class, 'show'])->name('issues.show');
    Route::get('/issues/{issue}/edit', [IssueController::class, 'edit'])->name('issues.edit');
    Route::put('/issues/{issue}', [IssueController::class, 'update'])->name('issues.update');
    Route::patch('/issues/{issue}/update-status', [IssueController::class, 'updateStatus'])->name('issues.updateStatus');
    Route::delete('/issues/{issue}', [IssueController::class, 'destroy'])->name('issues.destroy');

    // Route for report
    Route::get('/report', [ReportController::class, 'showReport'])->name('report.show');
});
