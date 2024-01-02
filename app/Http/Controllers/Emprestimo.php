<?php

namespace App\Http\Controllers;

use App\Models\Alunos;
use App\Models\Emprestimos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Emprestimo extends Controller
{
    public function Index()
    {
        $emprestimos = Emprestimos::all();

        return response()->json([
            "emprestimos" => $emprestimos
        ]);
    }
    public function Store(Request $request)
    {
        $data = $request->all();

        $data['inProgress'] = true;

        Emprestimos::create($data);

        return response()->json(['message' => 'Emprestimo realizado com sucesso'], 201);
    }

    public function Emprestimos()
    {

        $emprestimos = Emprestimos::where('inProgress', true)->get();

        return response()->json(['emprestimos' => $emprestimos], 200);
    }
    public function Pendentes()
    {

        $emprestimos = Emprestimos::where('inProgress', true)
            ->where('dataDeEntrega', '<', date('Y-m-d'))
            ->get();

        return response()->json(['emprestimos' => $emprestimos], 200);
    }

    public function Ranking()
    {
        $rankingStudents = Emprestimos::all()
            ->select('idDoAluno', DB::raw('COUNT(*) as total'))
            ->groupBy('idDoAluno')
            ->orderByDesc('total')
            ->get();

        return response()->json($rankingStudents);
    }



    public function Delete($id)
    {
        $Emprestimo = Emprestimos::find($id);

        if (!$Emprestimo) {
            return response()->json(['message' => 'Emprestimo não encontrado'], 404);
        }

        $data = [
            'inProgress' => false,
        ];

        $Emprestimo->update($data);

        return response()->json(['message' => 'Emprestimo deletado com sucesso'], 200);
    }
}
