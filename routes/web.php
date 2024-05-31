<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SurveyController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    Route::middleware(['checkUserType:2'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    });

    Route::middleware(['checkUserType:1'])->group(function () {
        Route::get('/superadmin', [SuperAdminController::class, 'index'])->name('superadmin');
        Route::get('/superadmin/surveys', [SurveyController::class, 'index'])->name('surveys.index');
        Route::get('/superadmin/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
        Route::post('/superadmin/surveys', [SurveyController::class, 'store'])->name('surveys.store');
        Route::get('/superadmin/surveys/{survey}', [SurveyController::class, 'show'])->name('surveys.show');
        Route::get('/superadmin/surveys/{survey}/questions/create', [SurveyController::class, 'createQuestion'])->name('surveys.questions.create');
        Route::post('/superadmin/surveys/{survey}/questions', [SurveyController::class, 'storeQuestion'])->name('surveys.questions.store');

    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
