<?php

namespace Modules\Core\App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\API\Traits\ApiResponse;

abstract class BaseFormRequest extends FormRequest
{
    use ApiResponse;

    protected function failedValidation(Validator $validator): void
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(
                $this->validationErrorResponse($validator->errors()->toArray()),
            );
        }

        parent::failedValidation($validator);
    }
}
