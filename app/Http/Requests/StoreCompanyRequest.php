<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
                'user_id' => 'required|exists:users,id',
                'industry' => 'required|string|max:255',
                'description' => 'required|string',
                'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                'city' => 'required|min:2|max:50|alpha',
                'country' => 'required|min:2|max:50|alpha',
                'address' => 'required|min:2|max:255',

                'mobile_phone' => 'required|string|max:255',
                'line_phone' => 'required|string|max:255',
                'website' => 'required|url',
                'linkedin_account' => 'nullable|url',
                'github_account' => 'nullable|url',
                'facebook_account' => 'nullable|url',

            ];

    }
}
