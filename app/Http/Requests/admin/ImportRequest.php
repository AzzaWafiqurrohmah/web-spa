<?php

namespace App\Http\Requests\admin;

use App\Exceptions\Api\FailedValidation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
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
            'fileImport' => 'mimes:csv,xls,xlsx'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return throw new FailedValidation($validator->errors());
    }
}
