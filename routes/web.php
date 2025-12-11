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

// AJAX for news
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

Route::post('/admin/pages/upload', [App\Http\Controllers\Admin\PageController::class, 'upload'])
    ->middleware('web')
    ->name('admin.pages.upload');
// Показване на категория по slug
Route::post('/admin/registration', [App\Http\Controllers\Admin\UserController::class, 'registerStore'])
    ->name('register.store');

Route::get('/admin', function () {
    return view('admin');
})->middleware('admin');

//Route::post('/admin/media/store', [MediaController::class, 'store'])->name('admin.media.store');
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('categories/trash', [CategoryController::class, 'trash'])
        ->name('categories.trash');
    Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])
        ->name('categories.restore');
    Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])
        ->name('categories.forceDelete');
    Route::resource('categories', CategoryController::class);

    Route::get('news/trash', [NewsController::class, 'trash'])->name('news.trash');
    Route::post('news/{id}/restore', [NewsController::class, 'restore'])->name('news.restore');
    Route::delete('news/{id}/force-delete', [NewsController::class, 'forceDelete'])->name('news.forceDelete');
    Route::post('/media/store', [MediaController::class, 'store'])->name('media.store');

    Route::get('pages/trash', [PageController::class, 'trash'])->name('pages.trash');
    Route::post('pages/{id}/restore', [PageController::class, 'restore'])->name('pages.restore');
    Route::delete('pages/{id}/force-delete', [PageController::class, 'forceDelete'])->name('pages.forceDelete');
});

Route::delete('/admin/media/{media}', [MediaController::class, 'destroy'])
    ->name('admin.media.destroy');

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

    // admin.dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

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


// Static pages – ALWAYS FINALLY!
Route::get('/{slug}', [App\Http\Controllers\Frontend\PageController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('page.show');

// Frontend routes
///Route::get('/pages/{slug}', [App\Http\Controllers\Frontend\PageController::class, 'show'])->name('pages.show');

require __DIR__.'/auth.php';
