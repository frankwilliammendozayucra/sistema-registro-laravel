<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Rutas de la Vista y Formulario Web
Route::get('/', [UsuarioController::class, 'index'])->name('registro.index');
Route::get('/registro', [UsuarioController::class, 'index']);
Route::post('/registro', [UsuarioController::class, 'store'])->name('registro.store');
Route::get('/usuarios', [UsuarioController::class, 'todos'])->name('usuarios.todos');

// Rutas de API y Métricas
Route::get('/metricas', [UsuarioController::class, 'metrics'])->name('metricas');
Route::get('/api/metricas', [UsuarioController::class, 'metrics'])->name('api.metricas');
Route::get('/api/usuarios', [UsuarioController::class, 'todos'])->name('api.usuarios');
Route::post('/api/usuarios', [UsuarioController::class, 'store'])->name('api.usuarios.store');
Route::match(['get', 'post'], '/api/stress-ping', [UsuarioController::class, 'stressPing'])->name('api.stress.ping');
