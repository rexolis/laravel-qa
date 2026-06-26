<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AcceptAnswerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('questions', QuestionController::class)
    ->except(['index', 'show'])
    ->middleware('auth');
    
Route::resource('questions', QuestionController::class)->only(['index']);
Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');
Route::post('/answers/{answer}/accept', AcceptAnswerController::class)
    ->name('answers.accept')
    ->middleware('auth');

Route::post('/questions/{question}/answers', [AnswerController::class, 'store'])
    ->name('questions.answers.store')
    ->middleware('auth');

Route::resource('questions.answers', AnswerController::class)
    ->only(['edit', 'update', 'destroy'])
    ->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
