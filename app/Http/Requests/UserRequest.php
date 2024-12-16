<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['nullable', 'regex:/^\+[1-9]\d{1,14}$/'],
            'full_name' => ['required', 'string', 'min:2', 'max:50'],
            'password' => ['required', 'string', 'min:8']
        ];
    }
}
