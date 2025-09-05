<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnvUpdateRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   */
  public function rules(): array
  {
    return [
      // Email Settings
      'mail' => 'nullable|bool',
      'mail_mailer' => 'required_if:mail=1|string',
      'mail_host' => 'required_if:mail=1|string',
      'mail_port' => 'required_if:mail=1|numeric',
      'mail_username' => 'required_if:mail=1|string',
      'mail_password' => 'required_if:mail=1|string',
      'mail_encryption' => 'required_if:mail=1|string',
      'mail_from_address' => 'required_if:mail=1|email',
      'mail_from_name' => 'required_if:mail=1|string',

      // Firebase Settings
      'firebase' => 'nullable|bool',
      'firebase_api_key' => 'required_if:firebase=1|string',
      'firebase_auth_domain' => 'required_if:firebase=1|string',
      'firebase_project_id' => 'required_if:firebase=1|string',
      'firebase_storage_bucket' => 'required_if:firebase=1|string',
      'firebase_messaging_sender_id' => 'required_if:firebase=1|string',
      'firebase_app_id' => 'required_if:firebase=1|string',
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
