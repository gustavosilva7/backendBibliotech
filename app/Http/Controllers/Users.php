<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\File;

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

            $path = $image->storeAs('uploads/users', $imageName);

            $data['image'] = $imageName;

            User::create($data);

            return response()->json(['message' => 'Upload realizado com sucesso!', 'image_path' => $imageName], 201);
        }

        User::create($data);

        return response()->json(['message' => 'Nenhuma imagem foi enviada.'], 400);
    }


    public function getImage($filename)
    {
        $path = storage_path('app/public/uploads/users/' . $filename);

        if (File::exists($path)) {
            $file = File::get($path);
            $type = File::mimeType($path);

            return response($file, 200)->header('Content-Type', $type);
        }

        return response()->json(["message" => "Imagem não encontrada"], 404);
    }


}
