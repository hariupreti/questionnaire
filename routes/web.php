<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\PublicAccessController;
use App\Http\Controllers\QuestionnaireController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Unauthorized Access
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

//Test Access using encrypted token
Route::get('/questionnaire/access/{token}', [PublicAccessController::class, 'accessTest'])->name('access.questionnaire');
Route::post('/questionnaire/record', [PublicAccessController::class, 'saveTestAnswer'])->name('save.answers');

// Authorized and verified access only
Route::middleware(['auth', 'verified'])->group(function () {
    //Profiles related routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Routes for questionnaire 
    Route::post('/questionnaire', [QuestionnaireController::class, 'store'])->name('questionnaire.save');
    Route::delete('questionnaire/{qid}', [QuestionnaireController::class, 'destroy'])->name('questionnaire.delete');
    Route::patch('/questionnaire', [QuestionnaireController::class, 'update'])->name('questionnaire.update');
});

require __DIR__ . '/auth.php';
