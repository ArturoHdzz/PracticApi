<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modelo;
use Illuminate\Support\Facades\Validator;

class ModeloController extends Controller
{
    
    public function index()
    {
        $modelos = Modelo::with('item')->get();
        return response()->json(["data" => $modelos]);
    }

    public function show($id)
    {
        $modelo = Modelo::with('item')->find($id);
        return response()->json(["data" => $modelo]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'item_id' => 'required|exists:items,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $modelo = new Modelo;
        $modelo->nombre = $request->nombre;
        $modelo->descripcion = $request->descripcion;
        $modelo->item_id = $request->item_id;
        $modelo->save();

        $modelo->load('item');

        return response()->json($modelo);
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'item_id' => 'required|exists:items,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $modelo = Modelo::find($id);
        $modelo->nombre = $request->nombre;
        $modelo->descripcion = $request->descripcion;
        $modelo->item_id = $request->item_id;
        $modelo->save();

        $modelo->load('item');

        return response()->json($modelo);
    }

    public function destroy($id)
    {
        $modelo = Modelo::find($id);
        $modelo->delete();
        return response()->json(['message' => 'Modelo eliminado']);
    }
}
