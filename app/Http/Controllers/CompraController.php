<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use Illuminate\Support\Facades\Validator;

class CompraController extends Controller
{
  
    public function index()
    {
        $compras = Compra::with('user', 'metodoPago', 'detallecompras')->get();
        return response()->json(["data" => $compras]);
    }

    public function show($id)
    {
        $compra = Compra::with('user', 'metodoPago', 'detallecompras')->find($id);
        return response()->json(["data" => $compra]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'total' => 'required|numeric',
            'metodo_pago_id' => 'required|exists:metodo_pagos,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $compra = new Compra;
        $compra->fecha = $request->fecha;
        $compra->total = $request->total;
        $compra->metodo_pago_id = $request->metodo_pago_id;
        $compra->user_id = $request->user_id;
        $compra->save(); 

        $compra->load('user', 'metodoPago');

        return response()->json($compra);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'total' => 'required|numeric',
            'metodo_pago_id' => 'required|exists:metodo_pagos,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $compra = Compra::find($id);
        $compra->fecha = $request->fecha;
        $compra->total = $request->total;
        $compra->metodo_pago_id = $request->metodo_pago_id;
        $compra->user_id = $request->user_id;
        $compra->save(); 

        $compra->load('user', 'metodoPago');

        return response()->json($compra);
    }

    public function destroy($id)
    {
        $compra = Compra::find($id);
        $compra->delete();
        return response()->json($compra);
    }
}
