<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;	
use Illuminate\Notifications\Notifiable;

class RegisterUser extends Authenticatable implements JWTSubject{
    use Notifiable;
    protected $table = 'register_users';
    
    public $timestamps = true;
    
    protected $fillable = [
        'name', 'surname', 'address', 'city', 'cp', 'telephone', 'email',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

}
