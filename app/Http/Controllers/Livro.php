<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livros;
use Illuminate\Support\Facades\Storage;

class Livro extends Controller
{
    public function Index()
    {
        $livros = Livros::orderBy('nomeLivro', 'asc')->get();

        return response()->json([
            'livros' => $livros
        ]);
    }
    public function Update($id, Request $request)
    {
        $livro = Livros::find($id);
        $data = $request->all();

        $livro->update($data);

        return response()->json([$livro]);

    }
    public function Store(Request $request)
    {
        $data = $request->all();
        $data['classificacaoLivro'] = true;
        $data['tombo'] = random_int(1, 9999);

        Livros::create($data);

        return response()->json(['message' => 'Livro cadastrado com sucesso'], 201);
    }
    public function GetClassificacao()
    {
        $livros = Livros::where('classificacaoLivro', true)
            ->orderBy('nomeLivro', 'asc')
            ->get();
        return response()->json(['livros' => $livros], 200);
    }
    public function LivroQuantOff($id)
    {
        $livro = Livros::find($id);
        if (!$livro) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }
        if ($livro->quantidade <= 0) {
            return response()->json(['message' => 'Livro indisponivel'], 200);
        } else {
            $livro->quantidade = $livro->quantidade - 1;
            if ($livro->quantidade == 0) {
                $data = [
                    'classificacaoLivro' => false,
                ];
                $livro->update($data);
            }
            $livro->save();
            return response()->json([
                'livro' => $livro,
            ]);
        }
    }
    public function LivroQuantOn($id)
    {
        $livro = Livros::find($id);
        if (!$livro) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        if ($livro->quantidade === 0) {
            $livro->quantidade = $livro->quantidade + 1;
            if ($livro->quantidade > 0) {
                $data = [
                    'classificacaoLivro' => true,
                ];
                $livro->update($data);
                $livro->save();
                return response()->json(['message' => 'Livro novamente disponivel'], 200);
            }
        } else {
            $livro->quantidade = $livro->quantidade + 1;
            $livro->save();
            return response()->json(['message' => 'Livro entregue com sucesso'], 200);
        }
    }
    public function LivroOff($id)
    {
        $Livro = Livros::find($id);

        if (!$Livro) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        $data = [
            'classificacaoLivro' => false,
        ];

        $Livro->update($data);

        return response()->json(['message' => 'Livro atualizado com sucesso'], 200);
    }
    public function LivroOn($id)
    {
        $Livro = Livros::find($id);

        if (!$Livro) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }

        $data = [
            'classificacaoLivro' => true,
        ];

        $Livro->update($data);

        return response()->json(['message' => 'Livro atualizado com sucesso'], 200);
    }
    public function destroy($id)
    {
        $livro = Livros::find($id);
        if ($livro) {
            $livro->delete();
            return response()->json(['message' => 'Livro deletado com sucesso']);
        } else {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }
    }
}
