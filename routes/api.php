<?php

use App\Http\Controllers\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Users; // Usuários
use App\Http\Controllers\Nota; // Notas
use App\Http\Controllers\Aluno; // Aluno
use App\Http\Controllers\Emprestimo; //Emprestimo
use App\Http\Controllers\UserImageProfileModelController; //imagem de perfil
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

//usuarios
Route::get('/user', [Users::class, 'Index']);
Route::get('/user/{id}', [Users::class, 'Find']);
Route::post('/user', [Users::class, 'Store']);


//notas
Route::get('/notas', [Nota::class, 'Index']);
Route::post('/notas', [Nota::class, 'Store']);
Route::get('/notas/ativas', [Nota::class, 'Find']);
Route::put('/notas/update/{id}', [Nota::class, 'Update']);
Route::put('/notas/delete/{id}', [Nota::class, 'Delete']);

//alunos
Route::get('/alunos', [Aluno::class, 'Index']);
Route::post('/alunos', [Aluno::class, 'Store']);
Route::get('/aluno/classificacao', [Aluno::class, 'GetClassificacao']);
Route::put('/aluno/disablealuno/{id}', [Aluno::class, 'AlunoOff']);
Route::put('/aluno/enablealuno/{id}', [Aluno::class, 'AlunoOn']);
// Route::get('/aluno/{id}', [Aluno::class, 'Find']);

//livros
Route::get('/livros', [Livro::class, 'Index']);
Route::post('/livros', [Livro::class, 'Store']);
Route::get('/livro/classificacao', [Livro::class, 'GetClassificacao']);
Route::put('/livro/disablelivro/{id}', [Livro::class, 'LivroOff']);
Route::put('/livro/enablelivro/{id}', [Livro::class, 'LivroOn']);

//Emprestimos
Route::get('/emprestimos', [Emprestimo::class, 'Index']);
Route::post('/emprestimos', [Emprestimo::class, 'Store']);
Route::get('/emprestimos/ativos', [Emprestimo::class, 'Emprestimos']);
Route::put('/emprestimos/{id}', [Emprestimo::class, 'Delete']);


//fotos de perfil
Route::get('/imagem', [UserImageProfileModelController::class, 'Index']);
Route::post('/imagem', [UserImageProfileModelController::class, 'Store']);
