<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('/courses', CourseController::class);
    Route::get('/courses/{course}/quiz', \App\Livewire\Quiz::class)->name('courses.quiz');

    Route::resource('courses.questions', QuestionController::class)
        ->only(['index', 'show']);

    Route::resource('questions', QuestionController::class)
        ->except(['index', 'show'])
        ->shallow();

});

Route::middleware('auth')->group(function () {
    Route::get('/profile/manage', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{user?}', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
