<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserImageProfileModel;

class UserImageProfileModelController extends Controller
{
    public function Index(){
        $image = UserImageProfileModel::all();

        return response()->json(['Imagem' => $image]);
    }
    public function Store(Request $request)
    {
        $data = $request->all();

        UserImageProfileModel::create($data);

        return response()->json(['message' => 'Imagem salva com sucesso'], 201);
    }
}
