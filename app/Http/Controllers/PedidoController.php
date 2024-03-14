<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Validator;

class PedidoController extends Controller
{
    

    public function index()
    {
        $pedidos = Pedido::with('user', 'metodoPago')->get();
        return response()->json(["data" => $pedidos]);
    }

    public function show($id)
    {
        $pedido = Pedido::with('user', 'metodoPago')->find($id);
        return response()->json(["data" => $pedido]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date_format:Y-m-d',
            'total' => 'required|numeric',
            'direccion' => 'required|string',
            'metodo_pago_id' => 'required|exists:metodo_pagos,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $pedido = new Pedido;
        $pedido->fecha = $request->fecha;
        $pedido->total = $request->total;
        $pedido->direccion = $request->direccion;
        $pedido->metodo_pago_id = $request->metodo_pago_id;
        $pedido->user_id = $request->user_id;
        $pedido->save(); 

        $pedido->load('user', 'metodoPago');

        return response()->json($pedido);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date_format:Y-m-d',
            'total' => 'required|numeric',
            'direccion' => 'required|string',
            'metodo_pago_id' => 'required|exists:metodo_pagos,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $pedido = Pedido::find($id);
        $pedido->fecha = $request->fecha;
        $pedido->total = $request->total;
        $pedido->direccion = $request->direccion;
        $pedido->metodo_pago_id = $request->metodo_pago_id;
        $pedido->user_id = $request->user_id;
        $pedido->save(); 

        $pedido->load('user', 'metodoPago');

        return response()->json($pedido);

    }

    public function destroy($id)
    {
        $pedido = Pedido::find($id);
        $pedido->delete();
        return response()->json($pedido);
    }
}
