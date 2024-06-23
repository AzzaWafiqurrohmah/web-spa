<?php

namespace App\Http\Requests\Therapist;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'image' => 'nullable',
            'fullname' => 'required|string',
            'birth_date' => 'required|date_format:Y-m-d',
            'gender' => 'required',
            'address' => 'required',
            'body_height' => 'required|int|min:0',
            'body_weight' => 'required|int|min:0',
            'phone' => 'required|size:12',
            'email' => 'required|email',
        ];
    }
}
