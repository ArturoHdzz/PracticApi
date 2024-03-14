<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleCompra;
use Illuminate\Support\Facades\Validator;
use App\Models\Item;

class DetalleCompraController extends Controller
{
    public function index()
    {
        $detalleCompras = DetalleCompra::with('modelo', 'compra')->get();
        return response()->json(["data" => $detalleCompras]);
    }

    public function show($id)
    {
        $detalleCompra = DetalleCompra::with( 'modelo',  'compra')->find($id);
        return response()->json(["data" => $detalleCompra]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'modelo_id' => 'required|exists:modelos,id',
            'compra_id' => 'nullable|exists:compras,id',
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

        $detalleCompra = new DetalleCompra;
        $detalleCompra->cantidad = $request->cantidad;
        $detalleCompra->precio = $request->precio;
        $detalleCompra->modelo_id = $request->modelo_id;
        $detalleCompra->compra_id = $request->compra_id;
        $detalleCompra->save();

        $detalleCompra->load('compra','modelo');

        return response()->json($detalleCompra);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'modelo_id' => 'required|exists:modelos,id',
            'compra_id' => 'nullable|exists:compras,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $item = Item::find($request->modelo_id);

        if ($request->cantidad > $item->stock) {
            return response()->json(['error' => 'No hay suficiente stock'], 400);
        }

        $detalleCompra = DetalleCompra::find($id);
        $detalleCompra->cantidad = $request->cantidad;
        $detalleCompra->precio = $request->precio;
        $detalleCompra->modelo_id = $request->modelo_id;
        $detalleCompra->compra_id = $request->compra_id;
        $detalleCompra->save(); 

        $detalleCompra->load('compra','modelo');

        return response()->json($detalleCompra);

    }

    public function destroy($id)
    {
        $detalleCompra = DetalleCompra::find($id);
        $detalleCompra->delete();
        return response()->json($detalleCompra);
    }

}
