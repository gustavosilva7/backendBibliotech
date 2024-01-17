<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livros;

class Livro extends Controller
{
    public function index(int $id = null)
    {
        $query = Livros::query();

        if (isset($id)) {
            $query->where('id', $id);
        }

        $books = $query->orderBy('id')->get();

        return response()->json([
            'livros' => $books
        ]);
    }

    public function onlyAvailableBooks()
    {
        return response()->json([
            'livros' => Livros::where('classificacaoLivro', true)->orderBy('id')->get(),
        ]);
    }

    public function update($id, Request $request)
    {
        $livro = Livros::find($id);
        $data = $request->all();

        $livro->update($data);

        return response()->json([$livro]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $livrosCriados = [];

        for ($i = 0; $i < $data['quantidade']; $i++) {
            $livro = Livros::create($data);
            $livrosCriados[] = $livro;
        }

        return response()->json(['message' => 'Livros cadastrados com sucesso', 'livros' => $livrosCriados], 201);
    }

    public function makeBookAvailable($id)
    {
        $book = Livros::find($id);

        if (!$book) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        $book->update([
            'classificacaoLivro' => true,
        ]);

        return response()->json(['livro' => $book], 200);
    }

    public function makeBookUnavailable($id)
    {
        $book = Livros::find($id);

        if (!$book) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        return response()->json(['livro' => $book], 200);
    }

    public function destroy($id)
    {
        $livro = Livros::find($id);

        if (!$livro) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        $livro->delete();
        $livros = Livros::all();

        return response()->json([
            'message' => 'Livro deletado com sucesso',
            'livros' => $livros
        ]);
    }
}
