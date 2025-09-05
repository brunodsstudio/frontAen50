<?php
namespace App\Http\Controllers\AuthJWT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;



class AuthProxyController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('Auth/Login');
    }


public function login(Request $request)
{
    $data = $request->validate([
    'email' => 'required|email',
    'password' => 'required|string',
    ]);


    $resp = Http::asJson()->post(rtrim(config('services.api.url', env('API_URL')), '/').'/login', $data);


    if ($resp->failed()) {
        return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
    }


    $payload = $resp->json();
    $token = \data_get($payload, 'access_token') ?? \data_get($payload, 'token');
    $expiresIn = (int) (\data_get($payload, 'expires_in') ?? 7200); // segundos


    if (!$token) {
        return back()->withErrors(['email' => 'Resposta da API sem token'])->withInput();
    }


    // Define cookie httpOnly com o JWT; duração baseada no expires_in
    $minutes = max(1, (int) ceil($expiresIn / 60));


    return redirect()->route('dashboard')
    ->withCookie(cookie(
        'jwt',
        $token,
        $minutes,
        '/',
        null,
        (bool) config('session.secure', false),
        true, // httpOnly
        false, // raw
        'Lax' // SameSite
    ));
}

public function mylogin(Request $request)
    {
        //$credentials = $request->only('email', 'password');

         $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            ]);



        if (Auth::guard('external_api')->attempt($credentials)) {
            // Authentication successful
            return redirect()->intended('/dashboard');
        } else{
             return back()->withErrors(['email' => 'Resposta da API sem token'])->withInput();
        }

        // Authentication failed
        return back()->withErrors(['email' => 'Invalid credentials']);
    }


public function logout(Request $request)
{
    // Opcional: chamar /auth/logout na API
    $token = $request->cookie('jwt');
    if ($token) {
        try {
            Http::withToken($token)->post(rtrim(env('API_URL'), '/').'/auth/logout');
        } catch (\Throwable $e) {
            
        }
    }
    return redirect()->route('login')->withCookie(cookie('jwt', null, -1, '/'));
    }

}