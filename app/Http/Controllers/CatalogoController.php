<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogo;
use Illuminate\Support\Facades\Validator;
use App\Events\TestingEvent;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Cache;

class CatalogoController extends Controller
{
    
    public function index(Request $request)
    {
        $catalogo = Catalogo::all();

        return response()->json(["data" => $catalogo]);
    }

    public function SSE(Request $request)
    {    
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        header('X-Accel-Buffering: no');
        header('Access-Control-Allow-Origin:*');

        if (Cache::has('SSEE')) {
            echo "data: " . json_encode(true) . "\n\n";
            ob_flush();
            flush();
        } else {
            echo "" . "\n\n";
            ob_flush();
            flush();
        }
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

        Cache::put('SSEE', 'created', 5);

        return response()->json(["msg"=>"catalogo creado", "data" => $catalogo], 201);
    }

    public function show($id){
        $catalogo = Catalogo::find($id);
        if($catalogo){
            return response()->json(["data" => $catalogo]);
        }else{
            return response()->json(["msg"=>"Catalogo not found"], 404);
        }
    }

    public function update(Request $request, $id){
        $catalogo = Catalogo::find($id);
        if($catalogo){
            //return response()->json(["msg"=>$request->nombre, "data" => $request->descripcion], 200);
            $catalogo->nombre = $request->nombre;
            $catalogo->descripcion = $request->descripcion;
            $catalogo->save();

            Cache::put('SSEE', 'updated', 5);

            return response()->json(["msg"=>"catalogo creado", "data" => $catalogo], 200);
        }else{
            return response()->json(["msg"=>"Catalogo not found"], 404);
        }
    }  

    public function destroy($id){
        $catalogo = Catalogo::find($id);
        if($catalogo){
            $catalogo->delete();

            Cache::put('SSEE', 'deleted', 5);
            
            return response()->json(["msg"=>"Catalogo deleted"], 200);
        }else{
            return response()->json(["msg"=>"Catalogo not found"], 404);
        }
    }
}

