<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeController;

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/theme', [ThemeController::class, 'update'])->name('theme.update');


Route::controller(App\Http\Controllers\LivroController::class)->prefix('livro')->name('livro.')->group(function () {
    Route::get('/listar', 'index')->name('listar');
    Route::get('/editar/{id}', 'edit')->name('index');
    Route::post('/editar/{id}', 'update')->name('index');
    Route::get('/cadastrar', 'edit')->name('index');
    Route::post('/cadastrar', 'store')->name('cadastrar');
    Route::delete('/deletar', 'delete')->name('deletar');
});

Route::controller(App\Http\Controllers\AutorController::class)->prefix('autor')->name('autor.')->group(function () {
    Route::get('/listar', 'index')->name('listar');
    Route::get('/editar/{id}', 'edit')->name('index');
    Route::post('/editar/{id}', 'update')->name('index');
    Route::get('/cadastrar', 'edit')->name('index');
    Route::post('/cadastrar', 'store')->name('cadastrar');
    Route::delete('/deletar', 'delete')->name('deletar');
});

Route::controller(App\Http\Controllers\AssuntoController::class)->prefix('assunto')->name('assunto.')->group(function () {
    Route::get('/listar', 'index')->name('listar');
    Route::get('/editar/{id}', 'edit')->name('index');
    Route::post('/editar/{id}', 'update')->name('index');
    Route::put('/editar/{id}', 'update')->name('index');
    Route::get('/cadastrar', 'edit')->name('index');
    Route::post('/cadastrar', 'store')->name('cadastrar');
    Route::delete('/deletar', 'delete')->name('deletar');
});

Route::controller(App\Http\Controllers\LivroAutorController::class)->prefix('livroautor')->name('livroautor.')->group(function () {
    Route::delete('/deletar-autor-livro', 'delete')->name('deletar');
});

Route::controller(App\Http\Controllers\LivroAssuntoController::class)->prefix('livroassunto')->name('livroassunto.')->group(function () {
    Route::delete('/deletar-assunto-livro', 'delete')->name('deletar');
});

