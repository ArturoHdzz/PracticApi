<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reseña;
use Illuminate\Support\Facades\Validator;

class ReseñaController extends Controller
{
        
    public function index()
    {
        $reseñas = Reseña::with('modelo', 'user')->get();
        return response()->json($reseñas);
    }

    public function show($id)
    {
        $reseña = Reseña::with('modelo', 'user')->find($id);
        return response()->json($reseña);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comentario' => 'required|string',
            'calificacion' => 'required|numeric',
            'fecha' => 'required|date',
            'modelo_id' => 'required|exists:modelos,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $reseña = new Reseña;
        $reseña->comentario = $request->comentario;
        $reseña->calificacion = $request->calificacion;
        $reseña->fecha = $request->fecha;
        $reseña->modelo_id = $request->modelo_id;
        $reseña->user_id = $request->user_id;
        $reseña->save(); 

        $reseña->load('modelo', 'user');

        return response()->json($reseña);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comentario' => 'required|string',
            'calificacion' => 'required|numeric',
            'fecha' => 'required|date',
            'modelo_id' => 'required|exists:modelos,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $reseña = Reseña::find($id);
        $reseña->comentario = $request->comentario;
        $reseña->calificacion = $request->calificacion;
        $reseña->fecha = $request->fecha;
        $reseña->modelo_id = $request->modelo_id;
        $reseña->user_id = $request->user_id;
        $reseña->save(); 

        $reseña->load('modelo', 'user');

        return response()->json($reseña);
    }

    public function destroy($id)
    {
        $reseña = Reseña::find($id);
        $reseña->delete();
        return response()->json($reseña);
    }
}
