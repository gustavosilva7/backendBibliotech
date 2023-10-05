<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livros;

class Livro extends Controller
{
    public function Index()
    {
        $livros = Livros::orderBy('nomeLivro', 'asc')->get();

        return response()->json([
            'livros' => $livros
        ]);
    }


    public function Store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('imagem')) {
            $imagemPath = $request->file('imagem')->store('storage/app/public');
            $data['imagem_path'] = $imagemPath;
        }

        $data['classificacaoLivro'] = true;

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
}
