<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notas;

class Nota extends Controller
{
    public function Index()
    {
        $notas = Notas::all();

        return response()->json(['notas' => $notas], 200);
    }
    
    public function Store(Request $request)
    {
        $data = $request->all();
        
        $data['isactive'] = true;
        
        Notas::create($data);
        
        return response()->json(['message' => 'Nota criada com sucesso'], 201);
    }
    public function Find()
    {
        $notas = Notas::where('isactive', true)->get();

        return response()->json(['notas' => $notas], 200);
    }


    public function Update(Request $request, $id)
    {
        $produto = Notas::find($id);

        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $data = $request->all();

        $produto->update($data);

        return response()->json(['message' => 'Produto atualizado com sucesso'], 200);
    }

    public function Delete($id)
    {
        $nota = Notas::find($id);

        if (!$nota) {
            return response()->json(['message' => 'nota não encontrado'], 404);
        }

        $data = [
            'isactive' => false,
        ];

        $nota->update($data);

        return response()->json(['message' => 'Nota deletada com sucesso'], 200);
    }
}
