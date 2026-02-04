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
   
    // Rotas públicas que não requerem JWT
    $publicRoutes = ['login', 'loginaction', 'register', 'password.request', 'password.email', 'password.reset', 'password.store', 'home'];
    
    if (in_array($routeName, $publicRoutes) || $request->path() === '/') {
        return $next($request);
    }

    // Verifica se o JWT está presente
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