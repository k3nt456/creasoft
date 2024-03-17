<?php

namespace App\Models\Customer\DataCustomer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCustomer extends Model
{
    use HasFactory;

    protected $table = 'tbl_data_customer';

    protected $fillable = [
        'cellphone',
        'dni',
        'ip',
        'revision_status',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    #Scopes
    public function scopeActiveForID($query, $id)
    {
        return $query->where('id', $id)->active();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    # Filtros
    public function scopeDataConsumerFilters($query)
    {
        #Filtro de fechas
        $query->when(
            request('initial_date') && request('final_date'),
            function ($query) {
                return $query->where(function ($query) {
                    $initialDate = request('initial_date');
                    $finalDate = request('final_date');
                    return $query->whereBetween('created_at', [$initialDate, $finalDate])
                                 ->orWhereDate('created_at', $initialDate)
                                 ->orWhereDate('created_at', $finalDate);
                });
            }
        );

        #Filtro de estado de revisión
        $query->when(
            request('revision_status') !== null,
            fn ($query) => $query->where('revision_status', request('revision_status'))
        )->when(
            request('revision_status') === null,
            fn ($query) => $query->where('revision_status', 1)
        );

        #Filtro de estados
        $query->when(
            request('status') !== null,
            fn ($query) => $query->where('status', request('status'))
        )->when(
            request('status') === null,
            fn ($query) => $query->where('status', 1)
        );

    }
}
