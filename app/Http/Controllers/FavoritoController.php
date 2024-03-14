<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorito;
use Illuminate\Support\Facades\Validator;

class FavoritoController extends Controller
{
    
    public function index()
    {
        $favoritos = Favorito::with('modelo', 'user')->get();
        return response()->json(["data" => $favoritos]);
    }

    public function show($id)
    {
        $favorito = Favorito::with('modelo', 'user')->find($id);
        return response()->json(["data" => $favorito]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modelo_id' => 'required|exists:modelos,id',
            'user_id' => 'required|exists:users,id',
            'fecha' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $favorito = new Favorito;
        $favorito->modelo_id = $request->modelo_id;
        $favorito->user_id = $request->user_id;
        $favorito->fecha = $request->fecha;
        $favorito->save(); 

        $favorito->load('modelo', 'user');

        return response()->json($favorito);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'modelo_id' => 'required|exists:modelos,id',
            'user_id' => 'required|exists:users,id',
            'fecha' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $favorito = Favorito::find($id);
        $favorito->modelo_id = $request->modelo_id;
        $favorito->user_id = $request->user_id;
        $favorito->fecha = $request->fecha;
        $favorito->save(); 

        $favorito->load('modelo', 'user');

        return response()->json($favorito);
    }

    public function destroy($id)
    {
        $favorito = Favorito::find($id);
        $favorito->delete();
        return response()->json($favorito);
    }

    
}
