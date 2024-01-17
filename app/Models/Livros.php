<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livros extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'classificacaoLivro',
        'nomeLivro',
        'autor',
        'editora',
        'edicao',
        'tombo',
        'lancamento'
    ];

    protected $attributes = [
        'classificacaoLivro' => true
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($book) {
            $book->tombo = random_int(1, 99999);
        });
    }
}
