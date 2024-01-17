<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimos extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nomeDoLivro',
        'autorDoLivro',
        'tomboDoLivro',
        'idDoLivro',
        'nomeDoAluno',
        'serieDoAluno',
        'turmaDoAluno',
        'idDoAluno',
        'dataDeEntrega',
        'inProgress',
        'created_at',
    ];

    protected $attributes = [
        'inProgress' => true,
    ];
}
