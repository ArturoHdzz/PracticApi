<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleCompra;
use Illuminate\Support\Facades\Validator;

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
            'cantidad' => 'required|integer',
            'precio' => 'required|numeric',
            'modelo_id' => 'required|exists:modelos,id',
            'compra_id' => 'nullable|exists:compras,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

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
            'cantidad' => 'required|integer',
            'precio' => 'required|numeric',
            'modelo_id' => 'required|exists:modelos,id',
            'compra_id' => 'nullable|exists:compras,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
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
