<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\Validator;
use App\Models\Item;


class DetallePedidoController extends Controller
{
    
    public function index()
    {
        $detallePedidos = DetallePedido::with( 'modelo', 'pedido')->get();
        return response()->json(["data" => $detallePedidos]);
    }

    public function show($id)
    {
        $detallePedido = DetallePedido::with('modelo', 'pedido')->find($id);
        return response()->json(["data" => $detallePedido]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'modelo_id' => 'required|exists:modelos,id',
            'pedido_id' => 'required|exists:pedidos,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $item = Item::find($request->modelo_id);

        if ($request->cantidad > $item->stock) {
            return response()->json(['error' => 'No hay suficiente stock'], 400);
        }

        $item->stock -= $request->cantidad;
        $item->save();
        $detallePedido = new DetallePedido;
        $detallePedido->cantidad = $request->cantidad;
        $detallePedido->precio = $request->precio;
        $detallePedido->modelo_id = $request->modelo_id;
        $detallePedido->pedido_id = $request->pedido_id;
        $detallePedido->save(); 

        $detallePedido->load('pedido', 'modelo');

        return response()->json($detallePedido);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'modelo_id' => 'required|exists:modelos,id',
            'pedido_id' => 'required|exists:pedidos,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $item = Item::find($request->modelo_id);

        if ($request->cantidad > $item->stock) {
            return response()->json(['error' => 'No hay suficiente stock'], 400);
        }

        $detallePedido = DetallePedido::find($id);
        $detallePedido->cantidad = $request->cantidad;
        $detallePedido->precio = $request->precio;
        $detallePedido->modelo_id = $request->modelo_id;
        $detallePedido->pedido_id = $request->pedido_id;
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
