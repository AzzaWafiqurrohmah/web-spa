<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TherapistRequest extends FormRequest
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
            'fullname' => 'required|string',
            'birth_date' => 'required|date_format:Y-m-d',
            'gender' => 'required',
            'address' => 'required',
            'body_height' => 'required|int|min:0',
            'body_weight' => 'required|int|min:0',
            'phone' => 'required|size:12',
            'start_working' => 'required|date_format:Y-m-d',
            'email' => 'required|email',
            'password' => 'nullable'
        ];

        if($this->getMethod() == 'POST') {
            $rules['password'] = 'required|size:8';
            $rules['email'] = 'required|email|unique:therapists,email';
        }

        return $rules;
    }
}
