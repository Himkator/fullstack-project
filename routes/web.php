<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AdminController;
use App\Models\User;    
use App\Http\Controllers\LanguageController;

Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::get('/', function () {return view('welcome');});

//Auth routes
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', function () {
    if (!session('user_role')) {
        return redirect('/login')->with('error', 'Please login first.');
    }

    $user = User::find(session('user_id'));

    // courses this user created (instructor/admin)
    $createdCourses = $user->courses()->get();

    // courses this user enrolled in (student)
    $enrolledCourses = $user->enrolledCourses()->get();

    return view('dashboard', compact('createdCourses', 'enrolledCourses'));
});
//Course routes
Route::get('/courses', [CourseController::class, 'showCourses']);
Route::get('/courses/{id}', [CourseController::class, 'showCourseDetails']);
Route::post('/manage-courses/store', [CourseController::class, 'createCourse']);
Route::post('/manage-courses/delete', [CourseController::class, 'deleteCourse']);
Route::get('/manage-courses', [CourseController::class, 'showManageCourses']);

//Admin routes
Route::get('/admin/manage-courses', [AdminController::class, 'showManageCourses']);
Route::get('/admin', [AdminController::class, 'showManageUsers']);
Route::post('/admin/change-role', [AdminController::class, 'changeUserRole']);

Route::post('/courses/enroll', [MailController::class, 'enroll']);
