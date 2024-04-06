<?php

namespace App\Http\Requests\Email;

use Illuminate\Foundation\Http\FormRequest;

class EmailConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'port' => ['required', 'numeric'],
            'host' => ['required', 'string'],
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'encryption' => ['required', 'string'],
            'from_name' => ['nullable', 'string'],
            'from_address' => ['nullable', 'string'],
        ];
    }

    public function attributes()
    {
        return [
            'pec_port' => "Port",
            'pec_host' => "Host",
            'pec_username' => "Username",
            'pec_password' => "Password",
            'pec_encryption' => "Encryption",
            'pec_from_name' => "From name",
            'pec_from_address' => "From address",
        ];
    }
}
