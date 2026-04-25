<?php

namespace Modules\AdminManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Admin user store request. Name kept for backward compatibility with
 * the existing controller binding; now validates a generic Codliy admin
 * (no medical fields).
 *
 * @property mixed $name
 * @property mixed $email
 * @property mixed $password
 * @property mixed $is_active
 * @property mixed $role
 * @property mixed $id
 */
class DoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role' => ['required', 'integer', 'exists:roles,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'unique:admins,email', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'img' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'is_active' => ['nullable', 'in:on,off'],
        ];
    }
}
