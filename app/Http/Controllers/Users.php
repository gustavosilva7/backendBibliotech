<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;

class Users extends Controller
{
    /**
     * @group Users
     *
     * GET api/users/{id?}
     *
     * Busca pelos usuários
     *
     * @urlParam id number ID do usuário
     */
    public function index(int $id = null)
    {
        $query = User::query();

        if (isset($id)) {
            $query->where('id', $id);
        }

        $users = $query->get();

        return response()->json([
            'usuarios' => $users
        ]);
    }

    /**
     * @group Users
     *
     * POST api/users
     *
     * Registra um novo usuário
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if($request->hasFile('imagem')) {
            $image = $request->file('imagem');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            Storage::disk('profile-photos')->put($imageName, $image);

            $path = Storage::disk('profile-photos')->url($imageName);

            return response()->json([
                'path' => $path,
                'message' => 'Upload realizado com sucesso!'
            ], 201);
          
        }

        User::create($data);

        return response()->json(['message' => 'Nenhuma imagem foi enviada.'], 400);
    }

    /**
     * @group Users
     *
     * GET api/users/image/{filename}
     *
     * Busca pela foto do usuário
     *
     * @urlParam filename string required Nome do arquivo
     */
    public function getImage($filename)
    {
        $path = Storage::disk('profile-photos')->url($filename);

        if (File::exists($path)) {
            $file = File::get($path);
            $type = File::mimeType($path);

            return response($file, 200)->header('Content-Type', $type);
        }

        return response()->json(["message" => "Imagem não encontrada"], 404);
    }


}
