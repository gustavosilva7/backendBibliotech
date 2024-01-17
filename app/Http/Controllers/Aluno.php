<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alunos;

class Aluno extends Controller
{
    /**
     * @group Alunos
     *
     * GET api/alunos/{onlyAvailable?}
     *
     * Realiza a busca de alunos
     *
     * @urlParam onlyAvailable bool A busca é apenas para os alunos disponíveis?
     */
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

    /**
     * @group Alunos
     *
     * POST api/alunos/
     *
     * Registra um novo aluno
     */
    public function store(Request $request)
    {
        $data = $request->all();

        Alunos::create($data);

        return response()->json(['message' => 'Aluno cadastrado com sucesso'], 201);
    }

    /**
     * @group Alunos
     *
     * PUT api/alunos/enablealuno/{id}
     *
     * Habilita um aluno
     *
     * @urlParam id number required ID do aluno
     */
    public function enableStudent($id)
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

    /**
     * @group Alunos
     *
     * PUT api/alunos/disablealuno/{id}
     *
     * Desabilita um aluno
     *
     * @urlParam id number required ID do aluno
     */
    public function disableStudent($id)
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
