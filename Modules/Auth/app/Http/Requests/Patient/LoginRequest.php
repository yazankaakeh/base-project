<?php

namespace Modules\Auth\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Admin back-office login request.
 *
 * Kept under the legacy "Patient" namespace for backward-compatibility after
 * the Codliy rebrand — LoginController still type-hints this class, and
 * extending FormRequest (which extends Illuminate\Http\Request) is required
 * so the ThrottlesLogins trait accepts it.
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

    public function attributes(): array
    {
        return [
            'email'    => __('Email'),
            'password' => __('Password'),
        ];
    }
}
