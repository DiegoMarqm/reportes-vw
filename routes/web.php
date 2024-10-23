<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ReporteController;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function (){
    return Inertia::render('Welcome');
});

Route::get('/dashboard', [EmpleadoController::class, 'getEmpleadosPorRol'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/about', fn() => Inertia::render('About'))->name('about');

    Route::get('/form', fn() => Inertia::render('Formulario'))->name('form');
    Route::get('/form-personal', fn() => Inertia::render('FormularioPersonal'))->name('form-personal');

    Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');
    Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create');
    Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');
    Route::delete('/empleados/{id}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');


    Route::get('/reporte', [ReporteController::class, 'index'])->name('reporte.index');
    Route::get('/reporte/create', [ReporteController::class, 'create'])->name('reporte.create');
    Route::post('/reporte', [ReporteController::class, 'store'])->name('reporte.store');

    Route::get('/reporte/{infoReporte}', [ReporteController::class, 'showReporte'])->name('reporte.show');

    Route::post('reporte/{infoReporte}/toggle-status', [ReporteController::class, 'toogleEstado'])->name('reporte.toggleEstado');




    Route::get('users', [UserController::class, 'index'])->name('users.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
