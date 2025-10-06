<?php

namespace Modules\AdminManagement\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Modules\Core\App\Enum\Gender;
use Modules\Core\App\Enums\ActiveEnum;

/**
 * @property mixed $role
 * @property mixed $password
 * @property mixed $is_active
 * @property mixed $email
 * @property mixed $name
 * @property mixed $id
 */
class UpdateDoctorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:doctors,id'],
            'role' => 'required|integer|exists:roles,id',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', Rule::unique('doctors')->ignore($this->id), 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'img' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_active' => ['required', new Enum(ActiveEnum::class)],
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
