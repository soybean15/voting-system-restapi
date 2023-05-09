<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasVoted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


         $user =  $request->user();

        if($user->hasVoted()){
            return  response()->json([
                "reason"=>$user->hasVoted(),
                "title" => 'You can only cast your vote once',
                "message" => "You can only cast your vote once, Try contacting the administrator if something went wrong thank you"
            ]);
        }
        return $next($request);
    }
}
