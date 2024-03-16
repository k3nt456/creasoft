<?php

namespace App\Models\User\TypeUser;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeUser extends Model
{
    use HasFactory;

    protected $table = 'tbl_type_user';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'status'
    ];

    # Relaciones
    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'idtype_user', 'id');
    }
}
