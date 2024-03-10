<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogo;
use Illuminate\Support\Facades\Validator;

class CatalogoController extends Controller
{
    
    public function index(){
        $catalogo = Catalogo::all();
        return response()->json($catalogo);
    }

    public function store(Request $request){
        $validate = validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'nullable'
        ]);

        if($validate->fails()){
            return response()->json($validate->errors(), 400);
        }

        $catalogo = new Catalogo();
        $catalogo->nombre = $request->nombre;
        $catalogo->descripcion = $request->descripcion;
        $catalogo->save();


        return response()->json(["msg"=>"catalogo creado", "data" => $catalogo], 201);
    }

    public function show($id){
        $catalogo = Catalogo::find($id);
        if($catalogo){
            return response()->json($catalogo);
        }else{
            return response()->json(["msg"=>"Catalogo not found"], 404);
        }
    }

    public function update(Request $request, $id){
        $catalogo = Catalogo::find($id);
        if($catalogo){
            $catalogo->nombre = $request->nombre;
            $catalogo->descripcion = $request->descripcion;
            $catalogo->save();
            return response()->json(["msg"=>"catalogo creado", "data" => $catalogo], 200);
        }else{
            return response()->json(["msg"=>"Catalogo not found"], 404);
        }
    }  

    public function destroy($id){
        $catalogo = Catalogo::find($id);
        if($catalogo){
            $catalogo->delete();
            return response()->json(["msg"=>"Catalogo deleted"], 200);
        }else{
            return response()->json(["msg"=>"Catalogo not found"], 404);
        }
    }
}

