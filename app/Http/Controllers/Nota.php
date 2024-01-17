<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notas;

class Nota extends Controller
{
    /**
     * @group Notas
     *
     * GET api/notas/
     *
     * Busca por todas as notas
     */
    public function index()
    {
        $notas = Notas::all();

        return response()->json(['notas' => $notas], 200);
    }

    /**
     * @group Notas
     *
     * POST api/notas/
     *
     * Registra uma nova noya
     */
    public function store(Request $request)
    {
        $data = $request->all();

        Notas::create($data);

        return response()->json(['message' => 'Nota criada com sucesso'], 201);
    }

    /**
     * @group Notas
     *
     * GET api/notas/ativas
     *
     * Busca por todas as notas ativas
     */
    public function findActives()
    {
        $notas = Notas::where('isactive', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['notas' => $notas], 200);
    }

    /**
     * @group Notas
     *
     * PUT api/notas/update/{id}
     *
     * Atualiza uma nota
     *
     * @urlParam id number requird ID da nota
     */
    public function update(Request $request, int $id)
    {
        $produto = Notas::find($id);

        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $data = $request->all();

        $produto->update($data);

        return response()->json(['message' => 'Produto atualizado com sucesso'], 200);
    }

    /**
     * @group Notas
     *
     * PUT api/notas/delete/{id}
     *
     * Realiza um soft delete de uma nota
     *
     * @urlParam id number required ID da nota
     */
    public function softDelete($id)
    {
        $nota = Notas::find($id);

        if (!$nota) {
            return response()->json(['message' => 'Nota não encontrado'], 404);
        }

        $data = [
            'isactive' => false,
        ];

        $nota->update($data);

        return response()->json(['message' => 'Nota deletada com sucesso'], 200);
    }
}
