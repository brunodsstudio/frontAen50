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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', [HomeController::class, 'show'])->name('home');


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




Route::middleware([RequireJwt::class])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/dashboard/eventos', fn() => Inertia::render('Eventos'))->name('dashboard.eventos');
    
    // Rotas de Matérias
    Route::get('/dashboard/materias', fn() => Inertia::render('Dashboard/Materias'))->name('dashboard.materias');
    Route::get('/dashboard/materias/criar', fn() => Inertia::render('Dashboard/Materias/Form'))->name('dashboard.materias.criar');
    Route::get('/dashboard/materias/editar/{id}', fn($id) => Inertia::render('Dashboard/Materias/Form', ['id' => $id]))->name('dashboard.materias.editar');
    Route::get('/dashboard/materias/{id}/imagens', fn($id) => Inertia::render('Dashboard/Materias/Imagens', ['id' => $id]))->name('dashboard.materias.imagens');
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

// Galeria proxy route - server-side request to API
Route::get('/galeria-proxy/{pastaS3}/{pagina}', [App\Http\Controllers\MateriaController::class, 'galeriaProxy'])
    ->name('galeria.proxy')
    ->where(['pagina' => '[0-9]+']);

// Rota para busca por tag (deve vir antes do catch-all)
Route::get('/tag/{tag}', [CategoriaController::class, 'showByTag'])->name('tag.show');

// Rota para categoria (com restrição específica)
Route::get('/{categoria}', [CategoriaController::class, 'show'])->name('categoria.show')
    ->where('categoria', 'Cinema|Games|Quadrinhos|Animes|Séries|Acontece|Agenda|Cosplay|Critica|HappyGeek|Incomming|Resenha|TOPTOP|Videos');

// Rota para matéria específica (catch-all - deve ser a última)
Route::get('/{linkTitulo}', [App\Http\Controllers\MateriaController::class, 'show'])
    ->name('materia.show');
