<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CommentController;

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
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    Route::middleware(['checkUserType:2'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    });

    Route::middleware(['checkUserType:1'])->group(function () {
        Route::get('/superadmin/surveys', [SurveyController::class, 'index'])->name('surveys.index');
        Route::get('/superadmin/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
        Route::post('/superadmin/surveys', [SurveyController::class, 'store'])->name('surveys.store');
        Route::get('/superadmin/surveys/{survey:slug}', [SurveyController::class, 'show'])->name('surveys.show');
        Route::get('/superadmin/surveys/{survey:slug}/edit', [SurveyController::class, 'edit'])->name('surveys.edit');
        Route::put('/superadmin/surveys/{survey:slug}', [SurveyController::class, 'update'])->name('surveys.update');
        Route::delete('/superadmin/surveys/{survey:slug}', [SurveyController::class, 'destroy'])->name('surveys.destroy');
        Route::get('/superadmin/surveys/{survey:slug}/questions/create', [SurveyController::class, 'createQuestion'])->name('surveys.questions.create');
        Route::post('/superadmin/surveys/{survey:slug}/questions', [SurveyController::class, 'storeQuestion'])->name('surveys.questions.store');


        // Routes for editing and deleting questions
        Route::get('/superadmin/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
        Route::put('/superadmin/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('/superadmin/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');



        // Routes for Categories
        Route::get('/superadmin/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/superadmin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/superadmin/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/superadmin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/superadmin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/superadmin/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');



        // Routes for Pages
        Route::get('/superadmin/pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('/superadmin/pages/create', [PageController::class, 'create'])->name('pages.create');
        Route::post('/superadmin/pages', [PageController::class, 'store'])->name('pages.store');
        Route::get('/superadmin/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/superadmin/pages/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::delete('/superadmin/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');

        // Routes for Comments
        Route::get('/superadmin/comments', [CommentController::class, 'index'])->name('comments.index');
        Route::get('/superadmin/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
        Route::put('/superadmin/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/superadmin/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
        Route::put('/superadmin/comments/{comment}/accept', [CommentController::class, 'accept'])->name('comments.accept');
        Route::put('/superadmin/comments/{comment}/spam', [CommentController::class, 'markAsSpam'])->name('comments.spam');

    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

});
// Public route to view a page
Route::get('/pages/{slug}', [PageController::class, 'show'])->name('pages.show');
Route::post('/pages/{slug}/comments', [PageController::class, 'storeComment'])->name('comments.store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
