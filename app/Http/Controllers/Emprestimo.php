<?php

namespace App\Http\Controllers;

use App\Models\Emprestimos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Emprestimo extends Controller
{
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

    public function store(Request $request)
    {
        $data = $request->all();

        Emprestimos::create($data);

        return response()->json(['message' => 'Emprestimo realizado com sucesso'], 201);
    }

    public function emprestimos()
    {
        $emprestimos = Emprestimos::where('inProgress', true)->get();

        return response()->json(['emprestimos' => $emprestimos], 200);
    }

    public function pendentes()
    {

        $emprestimos = Emprestimos::where('inProgress', true)
            ->where('dataDeEntrega', '<', date('Y-m-d'))
            ->get();

        return response()->json(['emprestimos' => $emprestimos], 200);
    }

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
