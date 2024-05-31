<?php

namespace App\Http\Requests\owner;

use App\Exceptions\Api\FailedValidation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'name' => 'required',
            'franchise_id' => 'required',
            'email' => 'required',
            'password' => 'nullable'
        ];

        if($this->getMethod() == 'POST'){
            $rules['password'] = 'required|size:8';
            $rules['email'] = 'required|unique:users,email';
        }
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        return throw new FailedValidation($validator->errors());
    }
}
