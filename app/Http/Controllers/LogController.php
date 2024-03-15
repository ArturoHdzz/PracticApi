<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['show', 'store']]);
    }

    public function show()
    {
        try {
            // DB::connection('mongodb')->getPdo();
            // return "Conexion Exitosa con MongoDB";

            $logs = Log::all();
            return response()->json($logs);

        } catch (\Exception $e) {
            return "Error al conectar a la base de datos: " . $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        $log = new Log();
        $log->title = $request->name; 
        $log->save();
 
        return response()->json(["result" => "ok"], 201);
    }
    
}
