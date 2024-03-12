<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\Validator;


class DetallePedidoController extends Controller
{
    
    public function index()
    {
        $detallePedidos = DetallePedido::with( 'modelo')->get();
        return response()->json(["data" => $detallePedidos]);
    }

    public function show($id)
    {
        $detallePedido = DetallePedido::with('modelo')->find($id);
        return response()->json(["data" => $detallePedido]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|numeric',
            'precio' => 'required|numeric',
            'modelo_id' => 'required|exists:modelos,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $detallePedido = new DetallePedido;
        $detallePedido->cantidad = $request->cantidad;
        $detallePedido->precio = $request->precio;
        $detallePedido->modelo_id = $request->modelo_id;
        $detallePedido->save(); 

        $detallePedido->load('pedido', 'modelo');

        return response()->json($detallePedido);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|numeric',
            'precio' => 'required|numeric',
            'modelo_id' => 'required|exists:modelos,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $detallePedido = DetallePedido::find($id);
        $detallePedido->cantidad = $request->cantidad;
        $detallePedido->precio = $request->precio;
        $detallePedido->modelo_id = $request->modelo_id;
        $detallePedido->save(); 

        $detallePedido->load('pedido', 'modelo');

        return response()->json($detallePedido);
    }

    public function destroy($id)
    {
        $detallePedido = DetallePedido::find($id);
        $detallePedido->delete();
        return response()->json(['message' => 'DetallePedido deleted']);
    }
}
