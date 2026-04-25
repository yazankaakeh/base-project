<?php

namespace Modules\Doctor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Doctor\Models\MedicalExamination;
use Modules\Doctor\Models\Patient;
use Modules\Doctor\Rules\UploadFileRule;

/**
 * @property mixed $model
 * @property mixed $model_id
 * @property mixed $files
 */
class UploadFileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'model' => ['required', Rule::in([MedicalExamination::class, Patient::class])],
            'model_id' => ['required', 'integer', new UploadFileRule(model: $this->model)],
            'files' => ['required', 'array'],
            'files.*' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
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
