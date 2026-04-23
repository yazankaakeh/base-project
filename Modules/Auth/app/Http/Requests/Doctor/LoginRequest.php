<?php

namespace Modules\Auth\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Legacy Doctor login request stub, kept as a proper FormRequest after the
 * Codliy rebrand so that any lingering references still resolve to a class
 * that extends Illuminate\Http\Request.
 */
class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];
    }
}
