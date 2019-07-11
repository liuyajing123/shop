<?php

namespace App\Http\Middleware;

use Closure;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $result = $request->session()->has('username');
        // dd($result);
        if($result){
            echo "登陆成功！";
        }
        $response = $next($request);
        echo 111;
        return $response;
        // return $next($request);
    }
}
