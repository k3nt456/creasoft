<?php

namespace App\Http\Controllers\Customer\DataCustomer\Request;

use App\Traits\HasResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DataCustomerStoreRequest extends FormRequest
{
    use HasResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cellphone' => ['required', 'integer', 'digits_between:1,9'],
            'dni'       => ['required', 'integer', 'digits_between:1,8'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse('Formato inválido.', 400, $validator->errors()));
    }
}
