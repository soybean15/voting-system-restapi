<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //$user = Auth::user();
        //return $request->all();
        $user =  $request->user();
        if(!$user->isAdmin()){
            return  response()->json([
                "status" => 0,
                "message" => "Unauthorize"
            ]);
        }
        return $next($request);
    }
}
