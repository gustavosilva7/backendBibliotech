<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;

class Users extends Controller
{
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

    public function store(Request $request)
    {
        $data = $request->all();

        if($request->hasFile('imagem')) {

            //get filename with extension
            $filenamewithextension = $request->file('imagem')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('imagem')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;

            //Upload File to s3
            Storage::disk('s3')->put($filenametostore, fopen($request->file('imagem'), 'r+'), 'public');

            //Store $filenametostore in the database
            $data['imame'] = $filenametostore;

            User::create($data);
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
