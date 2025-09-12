<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

// Redirect root to course creation
Route::get('/', function () {
    return redirect()->route('courses.create');
});
Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');

// Course routes
Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
