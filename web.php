<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AuthorController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/book-detail', [HomeController::class, 'show'])->name('book.detail');
Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

// Admin group with prefix
Route::prefix('admin')->name('admin.')->group(function () {

    // Make /admin open the login page directly
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('admin.root');

    // Login routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Protected admin routes (only admins)
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Book management routes
        Route::get('books', [BookController::class, 'index'])->name('books.index');
        Route::post('books', [BookController::class, 'store'])->name('books.store');
        Route::put('books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

        // Publisher management routes
        Route::get('publishers', [PublisherController::class, 'index'])->name('publishers.index');
        Route::get('publishers/data', [PublisherController::class, 'data'])->name('publishers.data');
        Route::post('publishers', [PublisherController::class, 'store'])->name('publishers.store');
        Route::put('publishers/{publisher}', [PublisherController::class, 'update'])->name('publishers.update');
        Route::delete('publishers/{publisher}', [PublisherController::class, 'destroy'])->name('publishers.destroy');

        // Category management routes
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/data', [CategoryController::class, 'data'])->name('categories.data');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Author management routes
        Route::get('authors', [AuthorController::class, 'index'])->name('authors.index');
        Route::get('authors/data', [AuthorController::class, 'data'])->name('authors.data');
        Route::get('authors/create', [AuthorController::class, 'create'])->name('authors.create');
        Route::post('authors', [AuthorController::class, 'store'])->name('authors.store');
        Route::get('authors/{author}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
        Route::put('authors/{author}', [AuthorController::class, 'update'])->name('authors.update');
        Route::delete('authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');
    });
});