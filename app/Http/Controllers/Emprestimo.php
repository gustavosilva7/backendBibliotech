<?php

namespace App\Http\Controllers;

use App\Models\Emprestimos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Emprestimo extends Controller
{
    /**
     * @group Empréstimos
     *
     * GET api/emprestimos
     *
     * Realiza uma busca dentre os empréstimos
     */
    public function index()
    {
        $emprestimos = Emprestimos::all();

        $ranking = Emprestimos::select("idDoAluno", DB::raw("COUNT(*) as total"))
            ->orderByDesc("total")
            ->groupBy("idDoAluno")
            ->get();

        return response()->json([
            "ranking" => $ranking,
            "emprestimos" => $emprestimos
        ]);
    }

    /**
     * @group Empréstimos
     *
     * POST api/alunos/
     *
     * Cadastra um novo empréstimo
     */
    public function store(Request $request)
    {
        $data = $request->all();

        Emprestimos::create($data);

        return response()->json(['message' => 'Emprestimo realizado com sucesso'], 201);
    }

    /**
     * @group Empréstimos
     *
     * GET api/emprestimos/ativos
     *
     * Busca por todos os empréstimos ativos
     */
    public function emprestimos()
    {
        $emprestimos = Emprestimos::where('inProgress', true)->get();

        return response()->json(['emprestimos' => $emprestimos], 200);
    }

    /**
     * @group Empréstimos
     *
     * GET api/emprestimos/pendentes
     *
     * Busca por todos os empréstimos pendentes
     */
    public function pendentes()
    {

        $emprestimos = Emprestimos::where('inProgress', true)
            ->where('dataDeEntrega', '<', date('Y-m-d'))
            ->get();

        return response()->json(['emprestimos' => $emprestimos], 200);
    }

    /**
     * @group Empréstimos
     *
     * GET api/emprestimos/ranking
     *
     * Busca pelo ranking
     */
    public function ranking()
    {
        $rankingStudents = Emprestimos::select(
            'idDoAluno',
            DB::raw('COUNT(*) as total'),
            DB::raw('MAX(created_at) as created_at')
        )
            ->groupBy('idDoAluno')
            ->orderByDesc('total')
            ->get();

        return response()->json($rankingStudents);
    }

    /**
     * @group Empréstimos
     *
     * PUT api/emprestimos/{id}
     *
     * Realiza um soft delete dos empréstimos
     *
     * @urlParam id number required ID do empréstimo
     */
    public function softDelete($id)
    {
        $emprestimo = Emprestimos::find($id);

        if (!$emprestimo) {
            return response()->json(['message' => 'Emprestimo não encontrado'], 404);
        }

        $emprestimo->update([
            'inProgress' => false,
        ]);

        return response()->json(['message' => 'Emprestimo deletado com sucesso'], 200);
    }
}
