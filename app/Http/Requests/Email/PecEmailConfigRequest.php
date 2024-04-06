<?php

namespace App\Http\Requests\Email;

use Illuminate\Foundation\Http\FormRequest;

class PecEmailConfigRequest extends FormRequest
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
            'pec_port' => ['required', 'numeric'],
            'pec_host' => ['required', 'string'],
            'pec_username' => ['required', 'string'],
            'pec_password' => ['required', 'string'],
            'pec_encryption' => ['required', 'string'],
            'pec_from_name' => ['nullable', 'string'],
            'pec_from_address' => ['nullable', 'string'],
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
