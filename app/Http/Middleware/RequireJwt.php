<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use Symfony\Component\HttpFoundation\Response;


class RequireJwt
{
public function handle(Request $request, Closure $next): Response
{
     $routeName = Req::route()->getName();
   // dd($request->cookies->all(), $routeName);

    if($routeName === 'login' || $routeName === 'loginaction' || $routeName === 'register' || $routeName === 'password.request' || $routeName === 'password.email' || $routeName === 'password.reset' || $routeName === 'password.store'){
        return $next($request);
    }

   if (!$request->cookies->has('jwt')) {
    // Se for solicitação Inertia/SSR, redirecione corretamente
        if ($request->expectsJson() || $request->header('X-Inertia')) {
            return redirect()->route('login');
        }
        return redirect()->route('login');
    }
    return $next($request);
}
}