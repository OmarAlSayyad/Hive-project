<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreFreelancePostRequest extends FormRequest
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
           // 'seeker_id'=>'nullable|exists:seekers,id',
           // 'company_id'=>'nullable|exists:companies,id',
            'category_id'=>'required|exists:categories,id',
            'title'=>'required|string',
            'description'=>'required|string',
            'delivery_date'=>'required|date',
            'min_budget'=>'required',
            'max_budget'=>'required',
            'skill_ids' => 'required|array',
            'skill_ids.*' => 'exists:skills,id',
        ];

    }
    public function messages()
    {
        return [
            'skill_ids.required' => 'The skill IDs field is required.',
            'skill_ids.array' => 'The skill IDs must be an array.',
            'skill_ids.*.exists' => 'The selected skill is invalid.',
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
