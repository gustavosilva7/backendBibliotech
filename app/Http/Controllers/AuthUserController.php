<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthUserController extends Controller
{
    public function register(Request $request, User $user)
    {
        $data = $request->all();

        $user->create($data);

        return response()->json([
            'message' => 'Seus dados foram cadastrados!'
        ]);
    }

    public function login(Request $request)
    {
        $user = User::where('nome', $request->nome)->first();
        if (!$user || $request->senha !== $user->senha) {
            return response()->json([
                'error' => 'Credenciais incorretas!'
            ]);
        }

        $token = $user->createToken($request->nome)->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        return response()->json([
            'message' => 'Você foi deslogado'
        ]);
    }

    public function user()
    {
        $user = auth()->user();

        return $user;
    }
}
