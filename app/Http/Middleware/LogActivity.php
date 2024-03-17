<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Models\User;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $log = new Log;
        $log->route = $request->path();
        $log->method = $request->method();

        if ($request->method() === 'DELETE') {
            $id = last(explode('/', $request->path()));
            $log->values = json_encode(['id' => $id]);
        } 
        else if ($request->method() === 'PUT') {
            $id = last(explode('/', $request->path()));
            $log->values = json_encode(['id' => $id, 'request_all' => $request->all()]);
        } 
        else {
            $log->values = json_encode($request->all());
        }
        
        $log->user_id = Auth::user()->id;
        $log->save();

        return $response;
    }
}
