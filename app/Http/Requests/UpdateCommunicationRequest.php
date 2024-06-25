<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommunicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mobile_phone' => 'required|string|max:255',
            'line_phone' => 'required|string|max:255',
            'website' => 'required|url',
            'linkedin_account' => 'nullable|url',
            'github_account' => 'nullable|url',
            'facebook_account' => 'nullable|url'
             ];

    }
}
