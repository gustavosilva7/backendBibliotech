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

        if($request->hasFile('imagem')){
            $image = $request->file('imagem');
            $imageName= time().'.'.$image->getClientOriginalExtension();
            $path = public_path('/uploads/imageUsers/');
            $image->move($path, $imageName);
        }

        User::create($data);

        return response()->json(['message' => $data], 201);
    }
}
