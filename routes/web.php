<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, PublicController, Admin\ContentController, Admin\DashboardController};

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/servicios', [PublicController::class, 'services'])->name('services.index');
Route::get('/servicios/{service:slug}', [PublicController::class, 'service'])->name('services.show');
Route::get('/proyectos', [PublicController::class, 'projects'])->name('projects.index');
Route::get('/proyectos/{project:slug}', [PublicController::class, 'project'])->name('projects.show');
Route::get('/noticias', [PublicController::class, 'posts'])->name('posts.index');
Route::get('/noticias/{post:slug}', [PublicController::class, 'post'])->name('posts.show');
Route::get('/nosotros', [PublicController::class, 'about'])->name('about');
Route::get('/contacto', [PublicController::class, 'contact'])->name('contact');
Route::post('/contacto', [PublicController::class, 'sendContact'])->middleware('throttle:5,1')->name('contact.send');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'create'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
});
Route::post('/admin/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('services', ContentController::class)->except('show')->parameters(['services' => 'content']);
    Route::resource('projects', ContentController::class)->except('show')->parameters(['projects' => 'content']);
    Route::resource('posts', ContentController::class)->except('show')->parameters(['posts' => 'content']);
    Route::patch('{type}/{content}/status', [ContentController::class, 'status'])->whereIn('type', ['service','project','post'])->name('content.status');
    Route::get('{type}/archivados', [ContentController::class, 'archived'])->whereIn('type', ['service','project','post'])->name('content.archived');
});
