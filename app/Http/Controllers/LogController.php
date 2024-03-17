<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{

    public function index()
    {
        $logs = Log::with('user')->get();

        return response()->json($logs);
    }

    
}
