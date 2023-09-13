<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alunos;

class Aluno extends Controller
{
    public function Index()
    {
        $alunos = Alunos::all();

        return response()->json([
            'aluno' =>$alunos
        ]);
    }
    public function Store(Request $request)
    {
        $data = $request->all();

        $data['classificacaoAluno'] = true;

        Alunos::create($data);

        return response()->json(['message' => 'Aluno cadastrado com sucesso'], 201);
    }

    public function GetClassificacao()
    {
        $aluno = Alunos::where('classificacaoAluno', true)->get();

        return response()->json(['aluno' => $aluno], 200);
    }

    // public function Find($id)
    // {
    //     $produto = Alunos::find($id);

    //     if ($produto) {
    //         return response()->json(['produto' => $produto], 200);
    //     } else {
    //         return response()->json(['message' => 'Produto não encontrado'], 404);
    //     }
    // }
    public function AlunoOff($id)
    {
        $aluno = Alunos::find($id);

        if (!$aluno) {
            return response()->json(['message' => 'aluno não encontrado'], 404);
        }

        $data = [
            'classificacaoAluno' => false,
        ];

        $aluno->update($data);

        return response()->json(['message' => 'aluno atualizado com sucesso'], 200);
    }
    public function AlunoOn($id)
    {
        $aluno = Alunos::find($id);

        if (!$aluno) {
            return response()->json(['message' => 'aluno não encontrado'], 404);
        }

        $data = [
            'classificacaoAluno' => true,
        ];

        $aluno->update($data);

        return response()->json(['message' => 'aluno atualizado com sucesso'], 200);
    }
}
