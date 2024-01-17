<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alunos;

class Aluno extends Controller
{
    public function index(bool $onlyAvailable = false)
    {
        $query = Alunos::query();

        if ($onlyAvailable) {
            $query->where('classificacaoAluno', true);
        }

        $students = $query->get();

        return response()->json([
            'aluno' => $students
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        Alunos::create($data);

        return response()->json(['message' => 'Aluno cadastrado com sucesso'], 201);
    }

    public function alunoOn($id)
    {
        $aluno = Alunos::find($id);

        if (!$aluno) {
            return response()->json(['message' => 'aluno não encontrado'], 404);
        }

        $aluno->update([
            'classificacaoAluno' => true
        ]);

        return response()->json(['message' => 'aluno atualizado com sucesso'], 200);
    }

    public function alunoOff($id)
    {
        $aluno = Alunos::find($id);

        if (!$aluno) {
            return response()->json(['message' => 'aluno não encontrado'], 404);
        }

        $aluno->update([
            'classificacaoAluno' => false
        ]);

        return response()->json(['message' => 'aluno atualizado com sucesso'], 200);
    }

}
