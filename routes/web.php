<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\NewsAjaxController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\PublicCategoryController;
use App\Http\Controllers\Admin\MediaController;
use App\Models\Page;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [NewsAjaxController::class, 'index'])->name('home');

// AJAX за новини
//Route::get('/news-ajax', [NewsAjaxController::class, 'ajax'])->name('news.ajax');
Route::get('/news/ajax', [App\Http\Controllers\NewsAjaxController::class, 'ajax'])
    ->name('news.ajax');
// Статични страници
Route::get('/about-us', function () {
    $page = Page::where('slug', 'about-us')->firstOrFail();
    return view('pages.show', compact('page'));
})->name('about');

Route::get('/contact', function () {
    $page = Page::where('slug', 'contact')->firstOrFail();
    return view('pages.show', compact('page'));
})->name('contact');



Route::get('/login', function () {
    return 'Admin dashboard';

})->middleware('admin');

Route::get('/categories', [PublicCategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/categories/search', [PublicCategoryController::class, 'index'])
    ->name('categories.search');

Route::get('/category/{slug}', [PublicCategoryController::class, 'show'])
    ->name('category.show');

Route::get('/category/{slug}', [App\Http\Controllers\CategoryController::class, 'show'])
    ->name('category.show');

Route::get('/categories/ajax', [App\Http\Controllers\CategoryAjaxController::class, 'index'])
    ->name('categories.ajax');

Route::post('/admin/pages/upload', [App\Http\Controllers\Admin\PageController::class, 'upload'])->name('admin.pages.upload');
// Показване на категория по slug
Route::post('/admin/registration', [App\Http\Controllers\Admin\UserController::class, 'registerStore'])
    ->name('register.store');

Route::get('/admin', function () {
    return view('admin');
})->middleware('admin');

//Route::post('/admin/media/store', [MediaController::class, 'store'])->name('admin.media.store');
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::post('/media/store', [MediaController::class, 'store'])->name('media.store');
});

Route::delete('/admin/media', [MediaController::class, 'destroy'])->name('admin.media.destroy');

Route::get('/admin/media/modal', [MediaController::class, 'modal'])
    ->name('admin.media.modal');
Route::get('/admin/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])
    ->name('admin.users.edit');

Route::put('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])
    ->name('admin.users.update');

Route::patch('/admin/users/{user}/toggle', [UserController::class, 'toggleAdmin'])
    ->name('admin.users.toggle')
    ->middleware('admin');
Route::prefix('admin')->middleware(['admin'])->group(function () {

    // ТОВА Е КЛЮЧОВОТО: admin.dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('news', NewsController::class)->names([
        'index' => 'news.index',
        'create' => 'news.create',
        'store' => 'news.store',
        'show' => 'news.show',
        'edit' => 'news.edit',
        'update' => 'news.update',
        'destroy' => 'news.destroy',
    ]);

    Route::resource('categories', CategoryController::class)->names([
        'index' => 'categories.index',
        'create' => 'categories.create',
        'store' => 'categories.store',
        'show' => 'categories.show',
        'edit' => 'categories.edit',
        'update' => 'categories.update',
        'destroy' => 'categories.destroy',
    ]);
    Route::resource('pages', PageController::class)->names([
        'index' => 'pages.index',
        'create' => 'pages.create',
        'store' => 'pages.store',
        'edit' => 'pages.edit',
        'update' => 'pages.update',
        'destroy' => 'pages.destroy',
    ]);
});
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', fn() => view('admin.dashboard'))->name('dashboard');
    Route::resource('news', NewsController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('pages', PageController::class);
    Route::resource('users', UserController::class);
});

Route::get('/news-ajax', [App\Http\Controllers\NewsAjaxController::class, 'ajax'])->name('news.ajax');
Route::get('/news/{id}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

Route::resource('menu', MenuController::class)->names('admin.menu');
Route::post('admin/menu/reorder', [MenuController::class, 'reorder'])->name('admin.menu.reorder');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('menu', MenuController::class)->parameters([
        'menu' => 'menuItem' // ← КЛЮЧОВО! Laravel ще търси $menuItem в контролера
    ]);
});
Route::get('/{slug}', function ($slug) {
    $page = \App\Models\Page::where('slug', $slug)->firstOrFail();
    return view('pages.show', compact('page'));
})->where('slug', '[A-Za-z0-9\-]+')->name('page.show');

Route::get('/admin/registration', [UserController::class, 'registration'])->name('registration');


// Статични страници – ВИНАГИ НАКРАЯ!
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('page.show');

require __DIR__.'/auth.php';
