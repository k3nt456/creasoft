<?php

namespace App\Http\Controllers\Customer\DataCustomer\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DataCustomersResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        switch ($this->revision_status) {
            case 0:
                $revisionStatusText = 'No contactado';
                break;
            case 1:
                $revisionStatusText = 'Aceptó oferta';
                break;
            case 2:
                $revisionStatusText = 'Rechazó oferta';
                break;
            case 3:
                $revisionStatusText = 'No contestó';
                break;
            case 4:
                $revisionStatusText = 'Hacer seguimiento';
                break;
            default:
                $revisionStatusText = 'Estado desconocido';
                break;
        }

        switch ($this->revision_status) {
            case 0:
                $statusText = 'Inactivo';
                break;
            case 1:
                $statusText = 'Activo';
                break;
            case 2:
                $statusText = 'Eliminado';
                break;

            default:
                $statusText = 'Estado desconocido';
                break;
        }

        return [
            'id'                    => $this->id,
            'cellphone'             => $this->cellphone,
            'dni'                   => $this->dni,
            'revision_status'       => $this->revision_status,
            'revision_status_text'  => $revisionStatusText,
            'created_at'            => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'status'                => $this->status,
            'status_text'           => $statusText
        ];
    }
}
