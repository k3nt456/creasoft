<?php

namespace App\Models\User;

use App\Models\User\TypeUser\TypeUser;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasUuids;

    protected $table = 'tbl_user';

    protected $fillable = [
        'username',
        'avatar',
        'dni',
        'name',
        'surname',
        'email',
        'cellphone',
        'birthdate',
        'password',
        'encrypted_password',
        'email_confirmation',
        'idtype_user',
        'status',
    ];

    protected $hidden = [
        'password',
        'encrypted_password',
        'created_at',
        'updated_at'
    ];

    #JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email'     => $this->email,
            'username'  => $this->username
        ];
    }

    #Relaciones
    public function typeUser(): HasOne
    {
        return $this->hasOne(TypeUser::class, 'id', 'idtype_user');
    }

    #Scopes
    public function scopeActiveForID($query, $id)
    {
        return $query->where('id', $id)->active();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
