<?php

namespace Modules\AdminManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Admin user update request. Name kept for backward compatibility.
 *
 * @property mixed $role
 * @property mixed $password
 * @property mixed $is_active
 * @property mixed $email
 * @property mixed $name
 * @property mixed $id
 */
class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:admins,id'],
            'role' => ['required', 'integer', 'exists:roles,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                Rule::unique('admins', 'email')->ignore($this->input('id')),
                'string',
                'email',
                'max:255',
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'img' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'is_active' => ['nullable', 'in:on,off'],
        ];
    }
}
