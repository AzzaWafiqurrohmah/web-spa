<?php

namespace App\Http\Requests;

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
        return [
            'fullname' => 'required|string',
            'birth_date' => 'required|date_format:m/d/Y',
            'phone' => 'required|size:12',
            'gender' => 'required',
            'home_pict' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'home_details' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longtitude' => 'required'
        ];
    }
}
