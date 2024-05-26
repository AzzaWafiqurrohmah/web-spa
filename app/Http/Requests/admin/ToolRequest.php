<?php

namespace App\Http\Requests\admin;

use App\Exceptions\Api\FailedValidation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ToolRequest extends FormRequest
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
        $rules = [
            'name' => 'required'
        ];

        if($this->getMethod() == 'POST')
            $rules['name'] = 'required|unique:tools,name';

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        return throw new FailedValidation($validator->errors());
    }
}
