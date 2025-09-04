<?php

namespace Modules\UserManagement\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $is_active
 * @property mixed $id
 */
class UpdateStatusAminRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   */
  public function rules(): array
  {
    return [
      'id' => ['required', 'integer', 'exists:admins,id'],
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
