<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreJobPostRequest extends FormRequest
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
            'company_id'=>'required|exists:companies,id',
            'category_id'=>'required|exists:categories,id',

            'title'=>'required|string',
            'description'=>'required|string',
            'job_requirement'=>'required',
            'address'=>'required',

            'gender'=>'required|string',
            'min_age'=>'required|numeric',
            'max_age'=>'required|numeric',

            'scientific_level'=>'required|string',
            'job_type'=>'required|string',
            'experience_years'=>'required|numeric',

            'min_salary'=>'required|numeric',
            'max_salary'=>'required|numeric',



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
