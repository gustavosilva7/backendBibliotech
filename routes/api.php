<?php

use App\Http\Controllers\Livro;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Users; // Usuários
use App\Http\Controllers\Nota; // Notas
use App\Http\Controllers\Aluno; // Aluno
use App\Http\Controllers\Emprestimo; //Emprestimo
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/users')->group(function () {
    Route::get('/{id?}', [Users::class, 'index'])->name('users.get');
    Route::post('/', [Users::class, 'store'])->name('users.post');
});

Route::get('/image/{filename}', [Users::class, 'getImage']);

Route::prefix('/notas')->group(function () {
    Route::get('/', [Nota::class, 'index'])->name('notas.get');
    Route::post('/', [Nota::class, 'store'])->name('notas.post');
    Route::put('/update/{id}', [Nota::class, 'update'])->name('notas.update');
    Route::put('/delete/{id}', [Nota::class, 'softDelete'])->name('notas.delete');
    Route::get('/ativas', [Nota::class, 'findActives'])->name('notas.ativas');
});

Route::prefix('/alunos')->group(function () {
    Route::get('/{onlyAvailable?}', [Aluno::class, 'index'])->name('alunos.get');
    Route::post('/', [Aluno::class, 'store'])->name('alunos.post');
    Route::put('/enablealuno/{id}', [Aluno::class, 'alunoOn'])->name('alunos.habilitar_aluno');
    Route::put('/disablealuno/{id}', [Aluno::class, 'alunoOff'])->name('alunos.desabilitar_aluno');
});

Route::prefix('/livros')->group(function () {
    Route::get('/classificacao', [Livro::class, 'onlyAvailableBooks'])->name('livros.only_available_books');
    Route::get('/{id?}', [Livro::class, 'index'])->name('livros.get');
    Route::post('/', [Livro::class, 'store'])->name('livros.post');
    Route::put('/update/{id}', [Livro::class, 'update'])->name('livros.update');
    Route::put('/enablelivro/{id}', [Livro::class, 'makeBookAvailable'])->name('livros.enable_book');
    Route::put('/disablelivro/{id}', [Livro::class, 'makeBookUnavailable'])->name('livros.enable_disable');
    Route::delete('/delete/{id}', [Livro::class, 'destroy'])->name('livros.delete');
});

Route::prefix('/emprestimos')->group(function () {
    Route::get('/', [Emprestimo::class, 'index'])->name('emprestimos.get');
    Route::post('/', [Emprestimo::class, 'store'])->name('emprestimos.post');
    Route::get('/ativos', [Emprestimo::class, 'emprestimos'])->name('emprestimos.ativos');
    Route::put('/pendentes', [Emprestimo::class, 'pendentes'])->name('emprestimos.pendentes');
    Route::put('/{id}', [Emprestimo::class, 'softDelete'])->name('emprestimos.update');
    Route::get('/ranking', [Emprestimo::class, 'ranking'])->name('emprestimos.ranking');
});
