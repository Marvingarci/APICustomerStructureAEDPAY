<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class PrimaryAcc extends Authenticatable implements MustVerifyEmail , JWTSubject
{
    use HasFactory, Notifiable;
    protected $primaryKey = 'pmaID';
    public $incrementing = false;
    protected $keyType = 'string';

    //protected $casts = ['pmaID' => 'varchar(36)'];

    protected $fillable = [
        'pmaID','firstName','lastName','email','password','aedAsignType'
    ];

    public function locations()
    {
        return $this->hasMany(LocationAcc::class);
    }

    public function paymentTypes()
    {
        return $this->hasMany(PaymentType::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
