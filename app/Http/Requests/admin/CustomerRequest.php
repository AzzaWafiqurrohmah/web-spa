<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'fullname' => 'required|string|unique:customers,fullname',
            'birth_date' => 'required|date_format:Y-m-d',
            'phone' => 'required|size:12|unique:customers,phone',
            'gender' => 'required',
            'home_details' => 'nullable',
            'address' => 'required'
        ];

        if ($this->isMethod('POST')){
            $rules['home_pict'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }


        return $rules;
    }
}
