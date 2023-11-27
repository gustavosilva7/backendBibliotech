<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Users extends Controller
{
    public function Index()
    {
        $usuarios = User::all();

        return response()->json([
            'usuarios' => $usuarios
        ]);
    }
    public function Find($id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario não encontrado'], 404);
        }

        return response()->json(['usuario' => $usuario]);
    }

    public function Store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('imagem')) {
            $image = $request->file('imagem');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Salvar a imagem usando o Storage
            $path = $image->storeAs('uploads/users', $imageName);

            // Adicionar apenas o nome do arquivo ao array de dados para salvar no banco de dados
            $data['image'] = $imageName;

            // Agora você pode salvar os dados no banco de dados, incluindo apenas o nome da imagem
            User::create($data);

            return response()->json(['message' => 'Upload realizado com sucesso!', 'image_path' => $imageName], 201);
        }

        // Se não houver arquivo de imagem, crie o usuário sem imagem
        User::create($data);

        return response()->json(['message' => 'Nenhuma imagem foi enviada.'], 400);
    }


    public function getImage($filename)
    {
        $path = ('http://192.168.0.12:9195/storage/uploads/users/' . $filename);

        return response()->json(["image" => $path]);



        if (File::exists($path)) {
            abort(404);
            // return response()->json(["image" => $path]);
        }

        // $file = File::get($path);
        // $type = File::mimeType($path);

        // return response($file, 200)->header('Content-Type', $type);
    }


}
