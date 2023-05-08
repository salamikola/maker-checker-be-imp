<?php


namespace App\Http\Requests;

use App\Responsables\ErrorResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class BaseFormRequest extends FormRequest
{

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $data = ['error_bag' => $validator->errors(),
            'error' => [$validator->errors()->first()]];
        $response = new Response(['message' => 'Validation Error',
            'success' => false, 'data' => $data], 442);
        throw new ValidationException($validator, $response);
    }
}
