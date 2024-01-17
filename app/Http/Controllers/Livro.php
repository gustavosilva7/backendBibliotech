<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livros;

class Livro extends Controller
{
    /**
     * @group Livros
     *
     * GET api/livros/{id?}
     *
     * Busca pelos livros
     *
     * @urlParam id number ID no livro
     */
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

    /**
     * @group Livros
     *
     * GET api/livros/classificacao
     *
     * Busca por todos os livros disponíveis
     */
    public function onlyAvailableBooks()
    {
        return response()->json([
            'livros' => Livros::where('classificacaoLivro', true)->orderBy('id')->get(),
        ]);
    }

    /**
     * @group Livros
     *
     * PUT api/livros/{id}
     *
     * Atualiza o cadastro de um livro
     *
     * @urlParam id number required ID do livro
     */
    public function update(int $id, Request $request)
    {
        $livro = Livros::find($id);
        $data = $request->all();

        $livro->update($data);

        return response()->json([$livro]);
    }

    /**
     * @group Livros
     *
     * POST api/livros
     *
     * Cadastra novos livros
     */
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

    /**
     * @group Livros
     *
     * PUT api/livros/enablelivro/{id}
     *
     * Torna um livro disponível
     *
     * @urlParam id number required ID do livro
     */
    public function makeBookAvailable(int $id)
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

    /**
     * @group Livros
     *
     * PUT api/livros/disablelivro/{id}
     *
     * Torna um livro indisponível
     *
     * @urlParam id number required ID do livro
     */
    public function makeBookUnavailable(int $id)
    {
        $book = Livros::find($id);

        if (!$book) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        return response()->json(['livro' => $book], 200);
    }

    /**
     * @group Livros
     *
     * DELETE api/livros/delete/{id}
     *
     * Deleta um livro
     *
     * @urlParam id number required ID do livro
     */
    public function destroy(int $id)
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
