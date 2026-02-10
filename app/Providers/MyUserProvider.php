<?php
// app/Providers/MyUserProvider.php
namespace App\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Cookie;
use App\Models\MyAuthenticatableUser;
use GuzzleHttp\Client; // Or any HTTP client

class MyUserProvider implements UserProvider
{
    public function retrieveById($identifier) { /* ... */ }
    public function retrieveByToken($identifier, $token) { /* ... */ }
    public function updateRememberToken(Authenticatable $user, $token) { /* ... */ }
     public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false): bool { return false; }

    public function retrieveByCredentials(array $credentials)
    {
        // Make API call to external service to validate credentials
        $client = new Client();
        $response = $client->post(rtrim(config('services.api.url', env('API_URL')), '/').'/login', [
            'json' => $credentials,
        ]);

        if ($response->getStatusCode() === 200) {

            $userData = json_decode($response->getBody(), true);
            
            // Ensure $userData is a valid array before proceeding
            if (!is_array($userData)) {
                return null;
            }
            
            // Optionally, you can store the token in a cookie or session
            $token = \data_get($userData, 'access_token') ?? \data_get($userData, 'token');
            $expiresIn = (int) (\data_get($userData, 'expires_in') ?? 7200); // segundos
            $minutes = max(1, (int) ceil($expiresIn / 60));
            Cookie::queue(cookie(
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

            // Return an object that implements Authenticatable
            return new MyAuthenticatableUser($userData);
        }

        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // This method can be used for further validation if needed,
        // but often, retrieveByCredentials handles the primary validation.
        return true; // Assuming validation happened in retrieveByCredentials
    }
}