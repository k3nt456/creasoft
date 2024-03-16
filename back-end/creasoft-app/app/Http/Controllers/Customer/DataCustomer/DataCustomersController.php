<?php

namespace App\Http\Controllers\Customer\DataCustomer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Customer\DataCustomer\Request\DataCustomerExportRequest;
use App\Http\Controllers\Customer\DataCustomer\Request\DataCustomerIndexRequest;
use App\Http\Controllers\Customer\DataCustomer\Request\DataCustomerStoreRequest;
use App\Services\Customer\DataCustomer\DataCustomersService;
use App\Traits\HasResponse;
use Illuminate\Http\Request;

class DataCustomersController extends Controller
{
    use HasResponse;
    /** @var DataCustomersService */
    private $dataCustomersService;

    public function __construct(DataCustomersService $dataCustomersService)
    {
        $this->dataCustomersService = $dataCustomersService;
    }

    public function index(Request $request)
    {
        $withPagination = $this->validatePagination($request->only('perPage', 'page'));
        return $this->dataCustomersService->index($withPagination);
    }

    public function store(DataCustomerStoreRequest $request)
    {
        return $this->dataCustomersService->store($request->validated());
    }

    public function exportData()
    {
        return $this->dataCustomersService->exportData();
    }
}
