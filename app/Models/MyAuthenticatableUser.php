<?php 
// app/Models/MyAuthenticatableUser.php
namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;

class MyAuthenticatableUser implements Authenticatable
{
    protected $attributes;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function getAuthIdentifierName() { return 'id'; }
    public function getAuthIdentifier() { 
        //return $this->attributes['id']; 
    }

    public function getAuthPassword() { return null; } // Password not stored locally
    public function getRememberToken() { return null; }
    public function setRememberToken($value) { /* ... */ }
    public function getAuthPasswordName() { return null; }
    public function getRememberTokenName() { return 'remember_token'; }
    public function getNameAttribute()
        {
            return $this->attributes['name']; // Assuming 'name' column exists
        }

        public function getEmailAttribute()
        {
            return $this->attributes['email']; // Assuming 'email' column exists
        }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }
}