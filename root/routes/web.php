<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamplesController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\User\BorrowerBookController;
use App\Http\Controllers\User\BookController;
use App\Http\Controllers\Admin\BorrowerController as AdminBorrowerController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\Admin\FileController;

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

//  Routes Team User
Route::get('sign-in', [UserController::class, 'loginUser'])->name('login');
Route::match(['get','post'],'/forgot-password',[UserController::class, 'forgotPassword'])->name('forgot.password');

Route::middleware('role')->group(function() {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authLogin'])->name('authLogin');
});

Route::middleware('user.auth.partial')->group(function () {
    Route::get('/', [App\Http\Controllers\User\HomeController::class, 'homeUser'])->name('home');

    Route::get('book/details/{id}', [BookController::class, 'show'])->name('book.details');
});

Route::middleware('user.auth')->group(function () {
    // User 
    Route::group(['prefix' => 'user'], function () {
        Route::get('info', [UserController::class, 'showUser'])->name('user.show');
        Route::post('changepassword', [UserController::class, 'changePassword'])->name('user.changePassword');
        Route::post('changeinfo', [UserController::class, 'editInfoUser'])->name('user.update');
        Route::post('/books/{id}/returned', [BookController::class, 'renewalBook'])->name('user.books.return');
        Route::post('/books/{id}', [BookController::class, 'reflectionBook'])->name('user.books.reflection');
        Route::get('/history', [App\Http\Controllers\User\HistoryUserController::class, 'getallByUser'])->name('history');
    });

    // Book
    Route::group(['prefix' => 'book'], function () {
        Route::post('return/{id}', [BookController::class, 'returnHandler'])->name('book.return');
        Route::post('/details/{id}', [BorrowerBookController::class, 'borrowBook'])->name('book.borrowdetail');
        Route::get('reflection/edit/{reflection_id}', [BookController::class, 'findReflection'])->name('book.reflection.edit');
        Route::post('/reflection/update/{reflection_id}', [BookController::class, 'updateReflection'])->name('book.reflection.update');
    });

    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('auth.logout');
    Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('authlogout');

    // Notification
    Route::post('markRead/{id}', [NotificationController::class, 'markRead'])->name('markRead');
    Route::get('markReadAll/{userId}', [NotificationController::class, 'markReadAll'])->name('markReadAll');
});

Route::get(

    'test',
    [ExamplesController::class, 'index']
)->name('profile');

Route::prefix('admin')->group(function(){
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::middleware('admin.auth')->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
        Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard');

        // user management
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('admin.users');
            Route::post('/create', [AdminUserController::class, 'store'])->name('users.store');
            Route::post('/block', [AdminUserController::class, 'block'])->name('admin.users.block');
            Route::post('/unBlock', [AdminUserController::class, 'unBlock'])->name('admin.users.unBlock');
            Route::post('/delete', [AdminUserController::class, 'destroy'])->name('users.delete');
            Route::get('/show/{id}', [AdminUserController::class, 'show'])->name('admin.users.show');
            Route::put('/show/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
            Route::put('/change-password/{id}', [AdminUserController::class, 'changePassword'])->name('admin.users.changePassword');
            Route::get('/{id}', [AdminUserController::class, 'showEditModal'])->name('admin.users.showEditModal');
        });

        // book management
        Route::group(['prefix' => 'books'], function () {
            Route::get('/', [AdminBookController::class, 'index'])->name('admin.books');
            Route::delete('/delete/{id}', [AdminBookController::class, 'destroy'])->name('admin.books.delete');
            Route::delete('/delete-giver/{id}', [AdminBookController::class, 'destroyGiver'])->name('admin.books.deleteGiver');
            Route::post('/create', [AdminBookController::class, 'create'])->name('admin.books.create');
            Route::get('/details/{id}', [AdminBookController::class, 'details'])->name('admin.books.details');
            Route::get('/fetch-data', [AdminBookController::class, 'fetchData'])->name('admin.books.fetchData');
            Route::post('/import-csv', [AdminBookController::class, 'importCsv'])->name('admin.books.import-csv');
            Route::post('/update', [AdminBookController::class, 'update'])->name('admin.books.update');
            Route::get('/edit/{id}', [AdminBookController::class, 'showEditModal'])->name('admin.books.showEditModal');
        });

        // category management
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [AdminCategoryController::class, 'index'])->name('admin.categories');
            Route::post('/create', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
            Route::get('/show/{id}', [AdminCategoryController::class, 'show'])->name('admin.categories.show');
            Route::post('/update/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
            Route::post('/delete/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.delete');
        });

        // book loan manager
        Route::group(['prefix' => 'borrowers'], function (){
            Route::get('/',[AdminBorrowerController::class, 'index'])->name('admin.borrowers');
        });

        // Download File mẫu
        Route::get('download/{filename}',[FileController::class, 'download'])->name('file.download');
        Route::post('markRead/{id}', [AdminNotificationController::class, 'markRead'])->name('admin.markRead');
        Route::get('markReadAll/{userId}', [AdminNotificationController::class, 'markReadAll'])->name('admin.markReadAll');
    });
});

