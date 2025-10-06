<?php

namespace Modules\AdminManagement\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Modules\Core\App\Enum\Gender;

/**
 * @property mixed $name
 * @property mixed $email
 * @property mixed $password
 * @property mixed $is_active
 * @property mixed $role
 * @property mixed $id
 */
class DoctorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'role' => 'required|integer|exists:roles,id',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'unique:doctors,email', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'numeric'],
            'img' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_active' => ['nullable', 'in:on,off'],
            'age' => ['required', 'numeric', 'between:18,100'],
            'medicalSpecialtyId' => ['required', 'exists:medical_specialties,id'],
            'gender' => ['required', new Enum(Gender::class)],
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
