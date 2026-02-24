<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\AuthJWT\AuthProxyController;
//use App\Http\Controllers\AuthJWT\ApiProxyController;
use App\Http\Middleware\RequireJwt;
use Inertia\Inertia;

/*Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});*/

Route::get('/', [HomeController::class, 'show'])->name('home');
Route::get('/home', [HomeController::class, 'show'])->name('home');

// Rotas de teste de login
//Route::get('/loginteste', [App\Http\Controllers\AuthJWT\AuthProxyController::class, 'showLoginTeste'])->name('loginteste.show');

//Route::post('/loginteste', [HomeController::class, 'showteste'])->name('loginteste.post');

Route::post('/loginteste', function () {
    return 'Hello World';
})->name('loginteste.post');

Route::get('blogin', function () {
        return view('auth.blogin');
    })->name('blogin');



/*Route::get('/home', function () {
    return Inertia::render('Home');
})->name('home');*/

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


