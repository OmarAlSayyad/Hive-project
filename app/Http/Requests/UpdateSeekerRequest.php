<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateSeekerRequest extends FormRequest
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
            'cv'=>'nullable|mimes:pdf|max:4096',
            'level'=>'nullable|string',
            'gender'=>'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bio'=>'nullable|string',
            'hourly_rate'=>'nullable',
            'birth_date'=>'nullable|string',

            'city' => 'nullable|min:2|max:50',
            'country' => 'nullable|min:2|max:50',
            'address' => 'nullable|min:2|max:255',

            'mobile_phone' => 'nullable|string|max:255',
            'line_phone' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'linkedin_account' => 'nullable|url',
            'github_account' => 'nullable|url',
            'facebook_account' => 'nullable|url'
        ];
    }




    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            'message' => 'Invalid data send',
            'details' => $errors->messages(),
        ], 422);
        throw new HttpResponseException($response);
    }
}
