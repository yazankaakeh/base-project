<?php

namespace Modules\Core\App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Base form request for API-shaped endpoints. Previously depended on a
 * `Modules\API\Traits\ApiResponse` trait that lived in a module we've
 * since removed — inlined the small bit of behavior we actually need
 * (a 422 JSON error response) so the class is self-contained and PHPStan
 * can resolve all its references.
 *
 * Not currently extended by any request, but kept because it's a useful
 * base for future API endpoints.
 */
abstract class BaseFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator): void
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(
                $this->validationErrorResponse($validator->errors()->toArray()),
            );
        }

        parent::failedValidation($validator);
    }

    /**
     * Emit a consistent JSON error envelope for API consumers. Matches the
     * "errors keyed by field" shape Laravel uses everywhere else.
     */
    protected function validationErrorResponse(array $errors): JsonResponse
    {
        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $errors,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
