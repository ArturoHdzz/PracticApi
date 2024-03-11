<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodoPago;
use Illuminate\Support\Facades\Validator;
class MetodoPagoController extends Controller
{

    public function index()
    {
        $metodoPagos = MetodoPago::all();
        return response()->json($metodoPagos);
    }

    public function show($id)
    {
        $metodoPago = MetodoPago::all()->find($id);
        return response()->json($metodoPago);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'tipo' => 'required',
        ]);
        $metodoPago = new MetodoPago;
        $metodoPago->nombre = $request->nombre;
        $metodoPago->descripcion = $request->descripcion;
        $metodoPago->tipo = $request->tipo;
        $metodoPago->save();

        return response()->json($metodoPago);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'tipo' => 'required',
        ]);
        $metodoPago = MetodoPago::find($id);
        $metodoPago->nombre = $request->nombre;
        $metodoPago->descripcion = $request->descripcion;
        $metodoPago->tipo = $request->tipo;
        $metodoPago->save();

        return response()->json($metodoPago);
    }

    public function destroy($id)
    {
        $metodoPago = MetodoPago::find($id);
        $metodoPago->delete();
        return response()->json($metodoPago);
    }
}
