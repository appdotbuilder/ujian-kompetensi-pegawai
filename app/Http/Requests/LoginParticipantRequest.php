<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'participant_number' => 'required|string|max:50',
            'token' => 'required|string|size:6',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'participant_number.required' => 'Participant number is required.',
            'token.required' => 'Token is required.',
            'token.size' => 'Token must be exactly 6 characters.',
        ];
    }
}