<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('catalogo')->get();
        return response()->json($items);
    }

    public function show($id)
    {
        $item = Item::with('catalogo')->find($id);
        return response()->json($item);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required',
            'stock' => 'required|integer',
            'precio' => 'required|numeric',
            'catalogo_id' => 'required|exists:catalogos,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $item = new Item;
        $item->nombre = $request->nombre;
        $item->descripcion = $request->descripcion;
        $item->stock = $request->stock;
        $item->precio = $request->precio;
        $item->catalogo_id = $request->catalogo_id;
        $item->save(); 

        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required',
            'stock' => 'required|integer',
            'precio' => 'required|numeric',
            'catalogo_id' => 'required|exists:catalogos,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $item = Item::find($id);
        $item->nombre = $request->nombre;
        $item->descripcion = $request->descripcion;
        $item->stock = $request->stock;
        $item->precio = $request->precio;
        $item->catalogo_id = $request->catalogo_id;
        $item->save();

        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();

        return response()->json('Item deleted successfully');
    }
}
