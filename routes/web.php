<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\AuthJWT\AuthProxyController;
//use App\Http\Controllers\AuthJWT\ApiProxyController;
use App\Http\Middleware\RequireJwt;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/imgEditor', function () {
    return Inertia::render('ImgEditor');
})->name('imgEditor');

/*
Route::get('/admin/crop', function () {
    return Inertia::render('Cropper');
})->name('crop');*/

Route::group(['prefix' => 'admin'], function () {
    Route::get('/crop', function () {
        return Inertia::render('Cropper');
    })->name('crop');
});




Route::middleware([RequireJwt::class])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
});

/*Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
