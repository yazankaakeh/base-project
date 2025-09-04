<?php

namespace Modules\UserManagement\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed $role
 * @property mixed $password
 * @property mixed $is_active
 * @property mixed $email
 * @property mixed $name
 * @property mixed $id
 */
class UpdateAdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:admins,id'],
            'role' => 'required|integer|exists:roles,id',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', Rule::unique('admins')->ignore($this->id), 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'img' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_active' => ['nullable', 'in:on,off'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
