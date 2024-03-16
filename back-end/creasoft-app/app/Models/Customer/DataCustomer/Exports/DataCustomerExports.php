<?php

namespace App\Models\Customer\DataCustomer\Exports;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DataCustomerExports extends Model
{
    use HasFactory;

    protected $table = 'tbl_data_customer_exports';

    protected $fillable = [
        'iduser',
        'date_export',
        'path',
        'total',
        'search_filters',
        'status'
    ];

    protected $casts = [
        'search_filters' => 'array',
    ];

    #Relaciones
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'iduser');
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
