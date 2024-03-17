<?php

namespace App\Services\Customer\DataCustomer;

use App\Exports\DataCustomerExportExcel;
use App\Http\Controllers\Customer\DataCustomer\Resources\DataCustomersResource;
use App\Models\Customer\DataCustomer\DataCustomer;
use App\Models\Customer\DataCustomer\Exports\DataCustomerExports;
use App\Traits\HasResponse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DataCustomersService
{
    use HasResponse;

    public function index($withPagination)
    {
        $dataCustomer = DataCustomer::dataConsumerFilters() # Filtrado por el modelo
            ->orderBy('id', 'asc');

        $dataCustomer = !empty($withPagination)
            ? $dataCustomer->paginate($withPagination['perPage'], page: $withPagination['page'])
            : $dataCustomer->get();

        $dataCustomer = DataCustomersResource::collection($dataCustomer);

        return $this->successResponse('Lectura exitosa.', $dataCustomer);
    }

    public function store($params)
    {
        try {
            DB::beginTransaction();

            # Verificar duplicado de registro
            $validate = $this->checkDuplicate($params);
            if (!$validate->original['status']) return $validate;

            $dataCustomer = DataCustomer::create([
                'cellphone' => $params['cellphone'],
                'dni'       => $params['dni'],
                'ip'        => request()->ip() # También se podría usar una API externa
            ]);

            DB::commit();
            return $this->successResponse('Su información ha sido registrada exitosamente. Estas a un paso de ser parte de nuestra familia.', $dataCustomer);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->externalError('durante el registro de su información.', $th->getMessage());
        }
    }

    private function checkDuplicate($params)
    {
        $dataCustomer = DataCustomer::where('cellphone', $params['cellphone'])
            ->where('dni', $params['dni'])
            ->where('revision_status', 0)
            ->active()
            ->first();

        if ($dataCustomer) return $this->errorResponse('Su información ha sido registrada exitosamente. Estas a un paso de ser parte de nuestra familia.', 200);

        return $this->successResponse('OK');
    }

    public function exportData()
    {
        $data = $this->index(null);
        $data = $data->original['data']['detail'] ?? false;
        if (!$data || count($data) == 0) return $this->errorResponse('No hay datos para exportar.', 400);

        try {
            DB::beginTransaction();

            # Generar registro de exportación
            DataCustomerExports::create([
                'iduser'            => auth()->user()->id,
                'date_export'       => now(),
                'total'             => count($data),
                'search_filters'    => request()->all(),
            ]);

            # Estructurar la data
            $data = $this->structureData($data);

            DB::commit();
            # Descargar excel con la data seleccionada
            return Excel::download(new DataCustomerExportExcel($data), 'data_customers.xlsx');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->externalError('durante la exportación de la información.', $th->getMessage());
        }
    }

    # Reiniciar los IDs en la colección y quitar las claves "revision_status" y "status"
    private function structureData($data)
    {
        $data = json_decode(json_encode($data));

        foreach ($data as $item) {
            unset($item->revision_status);
            unset($item->status);
        }

        return $data;
    }
}
